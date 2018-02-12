# Puppet Skilled Framework Sandbox

## Overview

[Puppet Skilled](https://github.com/globalis-ms/puppet-skilled-framework) is a PHP framework built on top of [CodeIgniter](https://www.codeigniter.com/). It adds some features to the original framework :

* [Composer](https://getcomposer.org/),
* [Eloquent](https://laravel.com/docs/5.5/eloquent) ORM,
* [Phinx](https://phinx.org/) database migrations,
* [Pimple](https://pimple.symfony.com/) dependency container,
* Views inspired by [CakePHP](https://book.cakephp.org/3.0/en/views.html),
* Services and libraries.

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



## Tutorial

This sandbox shows how to build a simple application using Puppet Skilled step by step. Each branch of this repository adds a new feature to the application as follows :

* [Step 1 : Basic architecture with a simple static page,](./tutorial/step1.md)
* [Step 2 : Authentication module,](./tutorial/step2.md)
* [Step 3 : Profile editing and language selection,](./tutorial/step3.md)
* [Step 4 : Contact list,](./tutorial/step4.md)
* [Step 5 : Users and companies backoffice.](./tutorial/step5.md)
