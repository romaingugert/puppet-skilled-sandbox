<?= $this->element(
    'crud/global_actions',
    [
        'actions' => [
            [
                'uri' => 'backoffice/user/add/',
                'label' =>  '<i class="material-icons">add</i> ' .  lang('general_action_add'),
                'extra' => [
                    'title' => lang('general_action_add'),
                    'class' => 'btn btn-primary',
                ]
            ]
        ]
    ]
);
?>
<?= $this->element(
    'crud/default_filter',
    [
        'filters' => $this->fetch('filters'),
        'pager' => $this->fetch('pager')->getResult()
    ]
) ?>

<?= $this->element(
   'crud/list',
   [
       'pager'  => $this->fetch('pager'),
       'displayed_fields' => [
           [
               'query_key' => 'username',
               'label' => 'lang:user_label_username',
           ],
           [
               'query_key' => 'name',
               'label' => 'lang:user_label_first-and-last-name',
               'formater' => function ($item) {
                   return html_escape($item->first_name . ' ' . $item->last_name);
               }
           ],
           [
               'query_key' => 'roles',
               'label' => 'lang:user_label_roles',
               'formater' => function ($item) {
                    $str = '';
                    foreach ($item->roles as $role) {
                        $str .= '<li>' . html_escape($role->name) . '</li>';
                    }
                    return '<ul>' . $str . '</ul>';
                }
           ],
           [
               'query_key' => 'active',
               'label' => 'lang:user_label_enable',
               'class' => 'table-actions',
               'formater' => function ($item) {
                   return $this->element('crud/active_action', ['item' => $item]);
               }
           ],
           [
               'label' => '',
               'class' => 'table-actions',
               'formater' => function ($item) {
                   return $this->block('list_actions', ['item' => $item]);
               }
            ],
        ],
    ]
);?>
