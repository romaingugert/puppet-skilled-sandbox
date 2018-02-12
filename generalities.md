# Generalities

## Installation

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


## Integrations

You'll find an `integrations/` folder with the Sass stylesheets, fonts, images and scripts by the application, as well as templates and snippets to help you edit them. This project uses [Bootstrap 4](https://getbootstrap.com/) HTML/CSS framework.

While you work on the integration files, execute `make watch` in the `integrations/` folder and visit `puppet-skilled-sandbox/integrations/` to see the changes on the templates in real time.

To see the changes in real time to the actual application, use `robo assets:watch` at the project root.

You can also use `make build` and `robo assets:build` if you only want to build the assets once.
