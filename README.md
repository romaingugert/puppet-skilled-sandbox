# Puppet Skilled Framework Sandbox


## Overview

[Puppet Skilled](https://github.com/globalis-ms/puppet-skilled-framework) is a PHP framework built on top of [CodeIgniter](https://www.codeigniter.com/). It adds some features to the original framework :

* [Composer](https://getcomposer.org/)
* [Eloquent](https://laravel.com/docs/5.5/eloquent) ORM
* [Phinx](https://phinx.org/) DB migrations
* [Pimple](https://pimple.symfony.com/) container
* [CakePHP](https://book.cakephp.org/3.0/en/views.html) views

This sandbox shows how to build a simple website using Puppet Skilled step by step. Each branch of this repository adds a new feature to the application as follows :

* Step 1 : Basic architecture with a simple static page
* Step 2 : Authentication module
* Step 3 : Profile editing and language switch
* Step 4 : Contact list
* Step 5 : Users and companies backoffice


## Prerequisites

Some tools which can be useful to know before playing with Puppet Skilled :

* [Git](https://git-scm.com/doc)
* [Composer](https://getcomposer.org/doc/)
* [CodeIgniter](https://www.codeigniter.com/user_guide/)
* [Robo](http://robo.li/getting-started/) (more particularly [Globalis Robo Tasks](https://github.com/globalis-ms/robo_task))


## Installation

Don't forget to create the database before the installation.

```
composer install
robo install
```


## Integrations

In this project, you'll find a `integrations/` folder with the SCSS stylesheets, fonts, images and scripts by the application, as well as templates and snippets to help you edit them.

While you work on the integration files, execute `make watch` in the `integrations/` folder and visit `puppet-skilled-sandbox/integrations/` to see the changes on the templates in real time.

To see the changes in real time to the actual application, use `robo assets:watch` at the project root.

You can also use `make build` and `robo assets:build` if you only want to build assets once.


## Step 1

This step provide a basic architecture for the application with a single static page (a controller and a view).
The languages are externalised using [CodeIgniter Language Class](https://www.codeigniter.com/userguide3/libraries/language.html).

### Views

Puppet Skilled's view layer is similar to CakePHP's and organised in five parts :

* Layout : Represents the presentational code around a view (for example header and footer). Here you'll find a different layout of authentified and unauthentified users.
* Template : Main part of the view, generally linked to a single action.
* Block : Template included in another template.
* Cell : A view handled by a mini controller (for example flash messages or a navigation bar).
* Element : Little and reusable views (for example form inputs).



## Step 2


### Migrations

Puppet Skilled uses [Phinx](https://phinx.org/) to handle changes in the database structure, and Robo tasks are already configured to use it.

* Create migration : `robo migrate:create NameInCamelCase`, the migration file is created in `migrations/`
* Run migration : `robo migrate:up`
* Roll back migration : `robo migrate:down`

You can also create and run seeds to insert data in your database.

* Create a seed : `robo seed:create SeedName`, the `SeedName.php` file is created in `seeds/`
* Run a seed : `robo seed:run [SeedName]`

Execute `robo seed:run` to create a company and three users.


### Dependency container

You can defined services and modules in the container in `application/hooks/PuppetSkilledBootstrap.php`.

* Authentication service : `\Globalis\PuppetSkilled\Auth\Authentication`
* Settings service : `\Globalis\PuppetSkilled\Settings\Settings`
* Queue service : `\Globalis\PuppetSkilled\Queue\Service`


### Authentication

`\Globalis\PuppetSkilled\Auth\Authentication`

* Permissions : Permissions are defined by a tree. If a user has an access to a higher level than the permission currently checked, the access is granted. For example, if a user has the backoffice permission, he also has any backoffice.* permission.
* Resources : A resource make users able to access to an entity. Extend `\Globalis\PuppetSkilled\Auth\Resource`.
* Roles : A role is a set of permissions and resources. If a role isn't linked to any resource, we consider it to have access to every resource.

In our case :

| Role          | frontoffice | backoffice | backoffice.user | backoffice.companies | Resource |
| ------------- | ----------- | ---------- | ----------------| -------------------- | -------- |
| user          | 1 | 0 | 0 | 0 | `App\Model\Company` |
| manager       | 1 | 0 | 1 | 0 | `App\Model\Company` |
| administrator | 1 | 1 | 0 | 0 | `NULL` |

Users defined :

* Michel User : user linked to the company Globalis Media Systems
* Michel Manager : manager linked to the company Globalis Media Systems
* Michel Administrator : administrator

### Queue

Tasks like sending mails can be handled by a job queue. A queue service is available in `\Globalis\PuppetSkilled\Queue\Service`. Jobs are defined in classes extending `\Globalis\PuppetSkilled\Queue\Queueable`.
The job is put into the queue as follows :

```php
<?php
app()->queueService->dispatch($job);
```

To execute the jobs in the queue, execute the following command at the root of the project :

```
php index.php queue
```


## Step 3

This step adds a simple form enabling the user to edit his informations, using CodeIgniter's [Form Validation Class](https://www.codeigniter.com/userguide3/libraries/form_validation.html), as well as a custom service, `App\Service\Language\Language`, to enable switching between English and French languages.


## Step 4

Adds a contact list module which lists the users of the platform. It uses two Puppet Skilled libraries :

#### QueryFilter

This library is located in `\Globalis\PuppetSkilled\Library\QueryFilter` and enable the developer to quickly create user filters on a SELECT request, to display users who belong to a certain company for instance.

```php
<?php
$filters = new QueryFilter(
    [
        'filters' => [                                          // Filter definitions using closures
            'last_name' => function($query, $value) {
                return $query
                    ->where('last_name', 'like', $value . '%');
            },
        ],
        'save' => 'frontoffice_contact_filters',                // Key for session storage
    ]
);
```

#### QueryPager

This library is located in `\Globalis\PuppetSkilled\Library\QueryPager` and enable the developer to quickly set up pagination and sorting on a SELECT request. 

```php
<?php
$pager = new QueryPager(
    [
        'limit_choices' => [10, 20, 50],                                // Items per page choices
        'limit' => 10,                                                  // Items per page by default
        'sort' => [                                                     // Sortable columns
            'last_name' => 'last_name',
            'first_name' => 'first_name',
            'email' => 'email',
        ],
        'save' => 'frontoffice_contact_pager',                          // Key for session storage
        'unique_order_key' => User::query()->getModel()->getKeyName()   // Unique key for ordering
    ]
);
```

See precise usage in `application/controllers/frontoffice/Contact.php` and the corresponding views.

## Step 5

This step adds a backoffice module to the application in order to edit companies and users. Two pages, `backoffice/company` and `backoffice/user` enable users to edit, add and delete companies and users.

Administrators have access to both of them whereas managers can only access the latest. Simple users don't have access to this module at all.

Moreover, managers only have the right to edit and add users from the companies they belong to.

To simplify access control, the Authentication service has been overloaded so we could add a method checking whether a user can edit another user entity.
