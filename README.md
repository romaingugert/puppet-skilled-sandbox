# Puppet Skilled Framework Sandbox


## Overview

[Puppet Skilled](https://github.com/globalis-ms/puppet-skilled-framework) is a PHP framework built on top of [CodeIgniter](https://www.codeigniter.com/). It adds some features to the original framework :

* [Composer](https://getcomposer.org/),
* [Eloquent](https://laravel.com/docs/5.5/eloquent) ORM,
* [Phinx](https://phinx.org/) database migrations,
* [Pimple](https://pimple.symfony.com/) dependency container,
* Views inspired by [CakePHP](https://book.cakephp.org/3.0/en/views.html),
* Services and libraries.

This sandbox shows how to build a simple application using Puppet Skilled step by step. Each branch of this repository adds a new feature to the application as follows :

* Step 1 : Basic architecture with a simple static page,
* Step 2 : Authentication module,
* Step 3 : Profile editing and language selection,
* Step 4 : Contact list,
* Step 5 : Users and companies backoffice.


## Prerequisites

Here are some tools which can be useful to know before playing with Puppet Skilled :

* [Git](https://git-scm.com/doc),
* [Composer](https://getcomposer.org/doc/),
* [CodeIgniter](https://www.codeigniter.com/user_guide/),
* [Robo](http://robo.li/getting-started/) (more particularly [Globalis Robo Tasks](https://github.com/globalis-ms/robo_task)).


## Generalities

### Installation

Don't forget to create the database before the installation, then run :

```
composer install
./vendor/bin/robo install
```

(Note: You can create an alias to be able to use `robo` instead of `./vendor/bin/robo`.)

Robo will ask you to enter some informations in order to build configuration files located in `.robo/build` :

* `config.php` : Sets up the environment constant, as well as the `systems`, `application` and `views` paths,
* `phinx.php` : Configuration file for Phinx (see Migrations in step 2),
* `application/config/config.php` : Main configuration file for the application,
* `application/config/database.php` : Database configuration,
* `application/config/email.php` : Emails configuration.

The Robo questions are defined in `.robo/config/properties.php` and the answers are stored in `.robo/config/my.config`.


### Integrations

You'll find an `integrations/` folder with the Sass stylesheets, fonts, images and scripts by the application, as well as templates and snippets to help you edit them. This project uses [Bootstrap 4](https://getbootstrap.com/) HTML/CSS framework.

While you work on the integration files, execute `make watch` in the `integrations/` folder and visit `puppet-skilled-sandbox/integrations/` to see the changes on the templates in real time.

To see the changes in real time to the actual application, use `robo assets:watch` at the project root.

You can also use `make build` and `robo assets:build` if you only want to build the assets once.


## Step 1

This step provide a basic architecture for the application with a single static page to present the main principles of Puppet Skilled.


### Configuration

The application configuration is done the same way as in CodeIgniter. The configurations files are located in `application/config`.

PuppetSkilled adds several files in this folder :

* `site_settings.php` : Defines the name and title of the application, as well as the different languages available and the autoloading lang files :

```php
$config['site_settings'] = [
    'name' => 'Puppet Skilled',         // Site name
    'title' => 'Puppet Skilled',        // Default page title
    'multilingual' => [                 // Multilingual settings (set empty array to disable this)
        'default'       => 'fr',
        'available'     => [
            'en' => [
                'label' => 'EN',        // label to be displayed on language switcher
                'value' => 'english',   // to match with CodeIgniter folders inside application/language/
                'local' => ['en_US.UTF8', 'en.UTF8'],
            ],
            'fr' => [
                'label' => 'FR',
                'value' => 'french',
                'local' => ['fr_FR.UTF8', 'fr.UTF8'],
            ]
        ],
        'autoload' => ['general'],      // Autoloads general_lang.php language file
    ],
];
```

* `template.php` : Defines the autoloaded scripts and styles for each layout available (see Views below), as well as the different folders containing the assets :

```php
$config['default'] = $config['empty'] = $config['simple'] = [
    "style_autoload" => [
        'main',                             // Autoloads main.css
    ],
    "script_autoload" => [
        'vendor',                           // Autoloads vendor.js
        'main'                              // Autoloads main.js
    ],
    'html_style_path' => 'public/styles',   // CSS path
    'html_script_path' => 'public/scripts', // JS path
    'html_image_path' => 'public/images',   // Images path
];
```


### Controllers

Controllers are classes extending `\Globalis\PuppetSkilled\Controller\Base` and located in the `application/controllers` folder. They can be used the same way as [CodeIgniter controllers](https://www.codeigniter.com/userguide3/general/controllers.html).

For now, only two controllers are defined :

* `Welcome.php` : a very simple controller with a single `index` method,
* `Miscellaneous.php` : a controller handling 404 errors.


### Views

Concerning the view layer, Puppet Skilled is similar to [CakePHP](https://book.cakephp.org/3.0/fr/views.html) : it is organised in four parts, each one representing a folder in `application/views`.

* Layout : Represents the presentational code around a view (for example header and footer). The layout used is defined in the controllers with the `$layout` attribute. In this project, you'll find three different layouts :
    * `simple.php` : Extremely simple layout composed of a simple header and the page content,
    * `empty.php` : Simple layout, used on pages where authentication is not needed,
    * `default.php` : Complete layout with navigation displayed when the user is authentified.
* Template : Main part of the view, generally linked to a single action. In the following example, the `my_controller/action.php` template will be automatically called by the `render()` method.

```php
class MyController extends \Globalis\PuppetSkilled\Controller\Base
{
    public function action()
    {
        $this->render();
    }
}
```

This method accepts two optional parameters : an array containing data to be sent to the view, and the template you want to be called, which is automatically wrapped into the layout.

* Block : Blocks are just particular templates, reuseable and included in other templates. You can include a block by using `$this->block($filename)` in a view.
* Cell : A view handled by a mini controller, totally independent from any other view or any other controller. They can be used by calling `$this->cell('Controller::method')` in a view. In this project you'll find three cells :
    * DebugBar : the Puppet Skilled debug bar,
    * Flash : displays the error and success alerts after user actions,
    * Navigation : displays the different navigation links of the application.
* Element : Little and reusable views (for example form inputs). They can be included by using `$this->element('element/path')` in your views.

When using the `block` and `element` methods, you can add an array as a parameter to send data to the block or element, and retrieve it in the view with `$this->fetch('key')`. For example, create an input element as follows :

```php
$this->element('form/block_input', 
    [
        'input_element' => 'form/input',
        'label' => 'lang:general_label_search',
        'name' => 'search',
    ]
);
```

In every view, the languages are externalised using [CodeIgniter Language Class](https://www.codeigniter.com/userguide3/libraries/language.html).


### Debug bar

Puppet Skilled provides developers with a debug bar, using the CodeIgniter [profiler](https://www.codeigniter.com/userguide3/general/profiling.html) and [benchmark](https://www.codeigniter.com/userguide3/libraries/benchmark.html) libraries. The profiler library is extended in `application/library/APP_Profiler.php`, and the DebugBar cell is in `application/views/Cell`.

The debug bar is displayed at the top of the page (it unfolds when the little red bug is clicked), and gives you access to useful pieces of information :

* Execution time,
* Memory usage,
* GET, POST and SESSION variables,
* Configuration variables,
* HTTP headers,
* SQL requests.

You can activate it by adding `$this->output->enable_profiler(true)` before calling the `render` method in your controllers.


## Step 2

This rather substantial step adds several functionalities to the application :

* Services and libraries definitions,
* Database creation and population,
* A complete authentication module to the application, enabling login, logout, password setup and password reset.

The architecture was also slightly modified, a Base controller in `application/core` was added to mutualise lang initialisation, access control, flash messages or the debug bar activation.


### Dependency container

Puppet Skilled uses [Pimple](https://pimple.symfony.com/) to manage the dependencies of the application. The container is located in `application/hooks/PuppetSkilledBootstrap.php` and is called by the [`pre_controller` hook of CodeIgniter](https://www.codeigniter.com/user_guide/general/hooks.html) in `application/config/hooks.php` :

```php
$hook['pre_controller'] = [
    'class'    => 'PuppetSkilledBootstrap',
    'function' => 'boot',
    'filename' => 'PuppetSkilledBootstrap.php',
    'filepath' => 'hooks',
];
```

You can define the different services your need as follows :

```php
use \Globalis\PuppetSkilled\Core\Application;

class PuppetSkilledBootstrap
{
    public function boot()
    {
        $application = Application::getInstance();
        $container = $application->getContainer();

        $container['serviceName'] = function () {
            return new App\Service\ServiceClass();
        };
    }
}
```

The service is then accessible in the whole application via `app()->serviceName` or `$this->serviceName` in controllers.

Some services are available and ready to use within Puppet Skilled :

* Authentication service : `\Globalis\PuppetSkilled\Auth\Authentication`,
* Settings service : `\Globalis\PuppetSkilled\Settings\Settings`,
* Queue service : `\Globalis\PuppetSkilled\Queue\Service`.

These services are described a few sections below.

This file also loads the [Session library](https://www.codeigniter.com/user_guide/libraries/sessions.html) and the ORM.


### Models and ORM

The model layer of Puppet Skilled extends [Eloquent](https://laravel.com/docs/5.5/eloquent), the ORM used by Laravel. To create a model, just write a class extending `Globalis\PuppetSkilled\Database\Magic\Model`.

Puppet also adds the possibility of adding some useful traits to your models :

* `\Globalis\PuppetSkilled\Database\Magic\Uuid` : Sets the model key to be an UUID string.
* `\Globalis\PuppetSkilled\Database\Magic\SoftDeletes` : Usage of a deleted_at field instead of actually removing an entity from the database when calling `$model->delete()`. Don't forget to add this field to your database structure.
* `\Globalis\PuppetSkilled\Database\Magic\Lock\Lockable` : Entity locking to prevent simultaneous interactions. Lock your entity by using `$entity->acquireLock()`, which returns false if it is already locked by another user, and release the lock once your modifications are done by calling `$entity->releaseLock()`. The lock is automatically destroyed after a delay defined by the `lockDefaultTime` attribute of the model, or 150 seconds if not defined.
* `\Globalis\PuppetSkilled\Database\Magic\Revisionable\Revisionable` : Keeps a history of every change made to the entity in the revision table. You may want to add a `$nonRevisionable` attribute to your model, containing all the fields whose modifications won't lead to a new revision (created_at, updated_at, deleted_at).


### Migrations

Puppet Skilled uses [Phinx](https://phinx.org/) to handle changes in the database structure, and Robo tasks are already configured to use it.

* Create a migration : `robo migrate:create NameInCamelCase`, the migration file is created in `migrations/`
* Run migrations : `robo migrate:up`
* Roll back a migration : `robo migrate:down`

You can also create and run seeds to insert data in your database.

* Create a seed : `robo seed:create SeedName`, the `SeedName.php` file is created in `seeds/`
* Run a seed : `robo seed:run [SeedName]`

Execute `robo seed:run` to create a company and three users.

The [Faker](https://github.com/fzaninotto/Faker) library might be useful while writing your seeds.


### Authentication

The Authentication module is built on the `\Globalis\PuppetSkilled\Auth\Authentication` service.

* Permissions : Permissions are defined by a tree. If a user has an access to a higher level than the permission currently checked, the access is granted. For example, if a user has the backoffice permission, he also has any backoffice.* permission.
* Resources : A resource makes users able to access to an entity. Extends `\Globalis\PuppetSkilled\Auth\Resource`.
* Roles : A role is a set of permissions and resources. If a role isn't linked to any resource, we consider it to have access to every resource.

In our case :

| Role          | frontoffice | backoffice | backoffice.user | backoffice.companies | Resource |
| ------------- | ----------- | ---------- | ----------------| -------------------- | -------- |
| user          | 1 | 0 | 0 | 0 | `App\Model\Company` |
| manager       | 1 | 0 | 1 | 0 | `App\Model\Company` |
| administrator | 1 | 1 | 0 | 0 | `NULL` |

Three users and a company are defined in the project seeds :

* Michel User : user linked to the company Globalis Media Systems,
* Michel Manager : manager linked to the company Globalis Media Systems,
* Michel Administrator : administrator.

You can handle the access to controllers and methods by using the `$guards` attribute of the controllers. This array is used by the `secureAccess` method of the Base controller. For example :

```php
protected $guards = [
    'index' => 'backoffice.user.view',
    'add' => 'backoffice.user.edit',
    'edit' => 'backoffice.user.edit',
    'delete' => 'backoffice.user.edit',
];
```

This way, users who have the backoffice.user permission will have access to every method, and users who have backoffice.user.view will only have access to `index`.

This service also provides some useful methods :

* `app()->authenticationService->isLoggedIn()` : Checks if the user is authentified.
* `app()->authenticationService->user()` : Returns the user currently authentified.
* `app()->authenticationService->userCan($permission, $resourceType, $resourceValue)` : Checks if the authentified user has the permission to access a certain resource (or has the global permission if the resources parameters are null).
* Login, logout, password setup and reset methods : see `vendor/globalis/puppet-skilled-framework/src/Auth/Authentication.php` for more details.

Sessions are handled by a custom session driver, which extends the [CodeIgniter driver](https://www.codeigniter.com/user_guide/libraries/sessions.html). This driver stores the sessions into the `sessions` table of the database. It is configured by the `sess_*` parameters in the `config/config.php` file.


### Settings

A settings service is avaible in `\Globalis\PuppetSkilled\Settings\Settings`, which enables you to retrieve global parameters for the application in the database. Settings are defined as a simple key-value structure, with an extra `autoload` field.

This service uses the `settings` table, and its usage is quite simple :

* `app()->settings->get($key)` : Retrieve a setting from the database.
* `app()->settings->update($key, $value)` : Change the value of a setting to `$value`.


### Queue

Tasks like sending mails can be handled by a job queue. A queue service is available in `\Globalis\PuppetSkilled\Queue\Service`. Jobs are defined in classes extending `\Globalis\PuppetSkilled\Queue\Queueable`.
The job is put into the queue as follows :

```php
app()->queueService->dispatch($job);
```

To execute the jobs in the queue, execute the following command at the root of the project :

```
php index.php queue
```

A queueable `App\Jobs\Mailer` class is available in `app/jobs` and uses the [CodeIgniter Email class](https://www.codeigniter.com/userguide3/libraries/email.html).


## Step 3

This step adds a simple form enabling the user to edit his personal informations, using the [CodeIgniter Form Validation Class](https://www.codeigniter.com/userguide3/libraries/form_validation.html).


### Custom services

This step provides you with a Language service to enable the user to switch between English and French languages. You can create your own services by extending the Puppet Skilled Service class as follows :

```php
namespace App\Service;

class Language extends \Globalis\PuppetSkilled\Service\Base
{

}
```

Just inject this service in the application in `application/hooks/PuppetSkilledBootstrap.php` :

```php
$container['languageService'] = function ($c) {
    return new \App\Service\Language();
};
```

Now you can use it in your application like any other services by calling `app()->languageService`.


### Helpers

The framework defines some useful functions in its core : see the file `/vendor/globalis/puppet-skilled-framework/src/Core/helpers.php`. It contains functions to help developers handling arrays and strings, or the `app()` function we have used before.

Moreover, in the `application/helpers` folder you'll find some files "extending" several [CodeIgniter native helpers](https://www.codeigniter.com/userguide3/general/helpers.html). We've extended the date, form, language and url helpers to improve some functions and add some others.

* `APP_date_helper.php` is using the great [Carbon library](http://carbon.nesbot.com/docs/), which extends the PHP [DateTime class](www.php.net/manual/en/class.datetime.php), in useful functions formating dates.
* `APP_form_helper.php` replaces `form_open` and adds functions to handle required fields.
* `APP_language_helper.php` adds the `lang_libelle` function which wraps the original `lang` function.
* `APP_url_helper.php` creates functions to help working with URLs (creating links, redirecting, etc).

Open these files to see the functions they provide and their precise usage. You can also define your own helpers - see the [CodeIgniter documentation](https://www.codeigniter.com/userguide3/general/helpers.html).


## Step 4

This step adds a contact list module which lists the users of the platform. It uses two Puppet Skilled libraries :

#### QueryFilter

This library is located in `\Globalis\PuppetSkilled\Library\QueryFilter` and enable the developer to quickly create user filters on a SELECT request, to display users who belong to a certain company for instance.

```php
$filters = new QueryFilter(
    [
        'filters' => [                                      // Filter definitions using closures
            'last_name' => function($query, $value) {
                return $query
                    ->where('last_name', 'like', $value . '%');
            },
        ],
        'save' => 'frontoffice_contact_filters',            // Key for session storage or false
        'method' => 'get',                                  // Method used by the form
        'action' => 'action',                               // Key of the POST/GET variable
        'filter_action' => 'filter',                        // Value of the variable to apply the filters
        'reset_action' => 'reset',                          // Value of the variable to clear the filters
        'default_filters' => [                              // Default value for the filters
            'last_name' => 'Default value',
        ],
    ]
);
```

Use `$filters->run(Model::query())` to run the filters and send `$filters` to your view, in which you create a corresponding form with an input field named `last_name` and using these methods of the QueryFilter object :

* `getActionName()` : key of the POST/GET variable sent by the form,
* `getResetActionValue()` : name of the submit button,
* `getFilterActionValue() `: name of the reset button.


#### QueryPager

This library is located in `\Globalis\PuppetSkilled\Library\QueryPager` and enable the developer to quickly set up pagination and sorting on a SELECT request. 

```php
$pager = new QueryPager(
    [
        'limit_choices' => [10, 20, 50],                    // Items per page choices
        'limit' => 10,                                      // Items per page by default
        'sort' => [                                         // Sortable columns
            'last_name' => 'last_name',
            'email' => 'email',
        ],
        'save' => 'frontoffice_contact_pager',              // Key for session storage
        'unique_order_key' => Model::query()                // Unique key for ordering or false
                                ->getModel()
                                ->getKeyName(),
        'page'  => 1,                                       // Default page number
        'request_param' => [                                // Available parameters to organise the results
            'page' => 'page',
            'order' => 'order',
            'direction' => 'direction',
            'limit' => 'pagesize'
        ],

    ]
);
```


Use `$pager->run(Model::query())` to run the pager and send it to your view, in which you can use these methods :

* `getResult()` : Returns an array with the following keys :

```php
[
    'result',           // Result of the SQL query
    'page',             // Current page
    'total',            // Total number of elements
    'perPage',          // Elements per page
    'prevPage',         // True if a previous page exists
    'nextPage',         // True if a next page exists
    'pageCount',        // Number of pages
    'sort',             // Columned used to order the results
    'direction',        // Direction of the ordering (asc/desc)
    'limit',            // Limit
    'limit_choices'     // Available limit choices
]
```

* `isSortable($fieldName)` : Checks if the column `$fieldName` is sortable.

In order to sort the results, use two GET parameters : `order` for the field name and `direction` for an ascending or descending sort (`asc` or `desc`).

CRUD elements are already available in order to use your filters and pager, or you can write your own.
See precise usage in `application/controllers/frontoffice/Contact.php`, the corresponding views in `application/views/frontoffice/contact/` and the CRUD elements in `application/views/Element/crud/`.


## Step 5

This step adds a backoffice module to the application in order to edit companies and users. Two pages, `backoffice/company` and `backoffice/user` enable users to edit, add and delete companies and users.

Administrators have access to both of them whereas managers can only access the latest. Simple users don't have access to the backoffice at all.

Moreover, managers only have the right to edit and add users belonging to the companies they belong to themselves.

To simplify access control, the Authentication service has been extended so we could add a method checking whether a user can edit another user entity.
