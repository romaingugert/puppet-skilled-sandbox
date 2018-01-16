<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \Globalis\PuppetSkilled\Library\FormValidation;
use \Globalis\PuppetSkilled\Database\Query\Expression;
use \App\Model\User as UserModel;
use \App\Model\Role as RoleModel;

class User extends \App\Core\Controller\BackOffice
{
    protected $autoload = [
        'helper' => [
            'form',
            'date'
        ],
    ];

    protected $guards = [
        'index' => 'backoffice.user.view',
        'add' => 'backoffice.user.add',
        'edit' => 'backoffice.user.edit',
        'active_toggle' => 'backoffice.user.edit',
        'delete' => 'backoffice.user.delete',
    ];

    public function index()
    {
        $query =  UserModel::query();

        $filters = new QueryFilter(
            [
                'filters' => [
                    'search' =>function($query, $value) {
                        return $query->where('last_name', 'like', $value.'%')
                            ->orWhere('first_name', 'like', $value.'%')
                            ->orWhere('username', 'like', $value.'%')
                            ->orWhere(new Expression('CONCAT(first_name, " ", last_name)'), 'like', $value.'%')
                            ->orWhere(new Expression('CONCAT(last_name, " ", first_name)'), 'like', $value.'%');
                    },
                ],
                'save' => 'backoffice_users_filters',
            ]
        );
        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'sort' => [
                    'name' => 'last_name',
                    'email' => 'email',
                ],
                'save' => 'backoffice_users_pager',
                'unique_order_key' => $query->getModel()->getKeyName()
            ]
        );

        $pager->run($filters->run($query));
        $this->render([
            'filters' => $filters,
            'pager' => $pager,
        ]);
    }

    public function add()
    {
        $this->addOrEdit();
    }

    public function edit($id = null)
    {
        $this->addOrEdit($this->getEditItem($id));
    }

    public function active_toggle($id = null)
    {
        if ($this->input->method() !== 'post') {
            redirect_referrer('backoffice/user');
        }
        $item = $this->getEditItem($id);
        $item->active = ($item->active? 0 : 1);
        $item->save();
        $item->releaseLock();
        $this->flashMessage('lang:general_message_edit-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/user');
    }

    public function delete($id = null)
    {
        if ($this->input->method() !== 'post' || !$id ||  !($item = UserModel::find($id))) {
            redirect_referrer('backoffice/user');
        }
        // Acquire Lock
        if (!$item->acquireLock()) {
            $this->flashMessage('lang:general_message_already-lock', 'lang:general_message_title-error', 'error');
            redirect_referrer('backoffice/user');
        }
        $this->flashMessage('lang:general_message_edit-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/user');
    }

    protected function addOrEdit(UserModel $user = null)
    {
        $validator = $this->getValidator($user);
        if (!$validator->run()) {
            $service = $this->languageService;
            $languages = $service->getLanguagesList();
            $this->render([
                'validator' => $validator,
                'roles' => RoleModel::all(),
                'languages' => $languages,
                'item' => $user,
            ]);
        } else {
            // flash message
            $flashMessage = ($user ? 'lang:general_message_edit-success' : 'lang:general_message_add-success');
            $item = ($user ?: new UserModel());
            $item->first_name = $validator->set_value('first_name');
            $item->last_name = $validator->set_value('last_name');
            $item->email = $validator->set_value('email');
            $item->timezone = $validator->set_value('timezone');
            $item->datetime_format = $validator->set_value('datetime_format');
            $item->language = $validator->set_value('language');
            $item->save();
            $item->roles()->sync($validator->set_value('roles[]'));
            $item->releaseLock();

            // notify user
            if ($validator->set_value('notify') == 1) {
                $token = $this->authenticationService->registerToken($item);
                $email = new \App\Job\Mailer();
                $content = str_replace(
                    [
                        '{{link}}',
                        '{{first_name}}',
                        '{{last_name}}',
                        '{{username}}',
                    ],
                    [
                        site_url('authentication/setup/' . $token),
                        $item->first_name,
                        $item->last_name,
                        $item->username,
                    ],
                    $this->lang->line('user_email_content_notify_setup')
                );



                $email->to($item->email)
                    ->subject($this->lang->line('user_email_title_notify_setup'))
                    ->message($content);
                $this->queueService->dispatch($email);
            }

            // redirect
            $this->flashMessage($flashMessage, 'lang:general_message_title-success', 'success');
            redirect('backoffice/user/edit/' . $item->getRouteKey());
        }
    }

    protected function getEditItem($id)
    {
        if (!$id ||  !($item = UserModel::find($id))) {
            redirect_referrer('backoffice/user');
        }
        // Acquire Lock
        if (!$item->acquireLock()) {
            $this->flashMessage('lang:general_message_already-lock', 'lang:general_message_title-error', 'error');
            redirect_referrer('backoffice/user');
        }
        return $item;
    }

    protected function getValidator($user = null)
    {
        $validator = new FormValidation();
        $validator->set_rules(
            'first_name',
            'lang:user_label_first-name',
            [
                'trim',
                'required'
            ]
        );
        $validator->set_rules(
            'last_name',
            'lang:user_label_last-name',
            [
                'trim',
                'required'
            ]
        );
        $validator->set_rules(
            'email',
            'lang:user_label_email',
            [
                'trim',
                'valid_email',
                [
                    'user_error_not_unique_email',
                    function ($value) use ($user) {
                        if (empty($value)) {
                            return true;
                        }
                        if ($user) {
                            $user = UserModel::where('username', $value)->where('id', '!=', $user->id)->count();
                        } else {
                            $user = UserModel::where('username', $value)->count();
                        }
                        if ($user !== 0) {
                            return false;
                        }
                        return true;
                    },
                ],
                'required'
            ]
        );
        $validator->set_rules(
            'roles[]',
            'lang:user_label_roles',
            [
                'trim',
                'required'
            ]
        );
        $validator->set_rules(
            'timezone',
            'lang:user_label_timezone',
            [
                'trim',
                'required'
            ]
        );
        $validator->set_rules(
            'datetime_format',
            'lang:user_label_date_format',
            [
                'trim',
                'required'
            ]
        );
        $validator->set_rules(
            'notify',
            'lang:user_label_notify',
            [
                'trim',
            ]
        );
        return $validator;
    }
}
