# Step 2

**[Prev: Step 1, Basic architecture with a simple static page,](./step1.md)**
**[Next: Step 3, Profile editing and language selection](./step3.md)**


This rather substantial step adds several functionalities to the application :

* Services and libraries definitions,
* Database creation and population,
* A complete authentication module to the application, enabling login, logout, password setup and password reset.

The architecture was also slightly modified, a Base controller in `application/core` was added to mutualise lang initialisation, access control, flash messages or the debug bar activation.


## Dependency container

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


## Models and ORM

The model layer of Puppet Skilled extends [Eloquent](https://laravel.com/docs/5.5/eloquent), the ORM used by Laravel. To create a model, just write a class extending `Globalis\PuppetSkilled\Database\Magic\Model`.

Puppet also adds the possibility of adding some useful traits to your models :

* `\Globalis\PuppetSkilled\Database\Magic\Uuid` : Sets the model key to be an UUID string.
* `\Globalis\PuppetSkilled\Database\Magic\SoftDeletes` : Usage of a deleted_at field instead of actually removing an entity from the database when calling `$model->delete()`. Don't forget to add this field to your database structure.
* `\Globalis\PuppetSkilled\Database\Magic\Lock\Lockable` : Entity locking to prevent simultaneous interactions. Lock your entity by using `$entity->acquireLock()`, which returns false if it is already locked by another user, and release the lock once your modifications are done by calling `$entity->releaseLock()`. The lock is automatically destroyed after a delay defined by the `lockDefaultTime` attribute of the model, or 150 seconds if not defined.
* `\Globalis\PuppetSkilled\Database\Magic\Revisionable\Revisionable` : Keeps a history of every change made to the entity in the revision table. You may want to add a `$nonRevisionable` attribute to your model, containing all the fields whose modifications won't lead to a new revision (created_at, updated_at, deleted_at).


## Migrations

Puppet Skilled uses [Phinx](https://phinx.org/) to handle changes in the database structure, and Robo tasks are already configured to use it.

* Create a migration : `robo migrate:create NameInCamelCase`, the migration file is created in `migrations/`
* Run migrations : `robo migrate:up`
* Roll back a migration : `robo migrate:down`

You can also create and run seeds to insert data in your database.

* Create a seed : `robo seed:create SeedName`, the `SeedName.php` file is created in `seeds/`
* Run a seed : `robo seed:run [SeedName]`

Execute `robo seed:run` to create a company and three users.

The [Faker](https://github.com/fzaninotto/Faker) library might be useful while writing your seeds.


## Authentication

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


## Settings

A settings service is avaible in `\Globalis\PuppetSkilled\Settings\Settings`, which enables you to retrieve global parameters for the application in the database. Settings are defined as a simple key-value structure, with an extra `autoload` field.

This service uses the `settings` table, and its usage is quite simple :

* `app()->settings->get($key)` : Retrieve a setting from the database.
* `app()->settings->update($key, $value)` : Change the value of a setting to `$value`.


## Queue

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

**[Prev: Step 1, Basic architecture with a simple static page,](./step1.md)**
**[Next: Step 3, Profile editing and language selection](./step3.md)**
