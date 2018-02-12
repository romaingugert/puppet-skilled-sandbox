# Step 3

**[Prev: Step 2, Authentication module](./step2.md)**
**[Next: Step 4, Contact list](./step4.md)**


This step adds a simple form enabling the user to edit his personal informations, using the [CodeIgniter Form Validation Class](https://www.codeigniter.com/userguide3/libraries/form_validation.html).


## Custom services

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


## Helpers

The framework defines some useful functions in its core : see the file `/vendor/globalis/puppet-skilled-framework/src/Core/helpers.php`. It contains functions to help developers handling arrays and strings, or the `app()` function we have used before.

Moreover, in the `application/helpers` folder you'll find some files "extending" several [CodeIgniter native helpers](https://www.codeigniter.com/userguide3/general/helpers.html). We've extended the date, form, language and url helpers to improve some functions and add some others.

* `APP_date_helper.php` is using the great [Carbon library](http://carbon.nesbot.com/docs/), which extends the PHP [DateTime class](www.php.net/manual/en/class.datetime.php), in useful functions formating dates.
* `APP_form_helper.php` replaces `form_open` and adds functions to handle required fields.
* `APP_language_helper.php` adds the `lang_libelle` function which wraps the original `lang` function.
* `APP_url_helper.php` creates functions to help working with URLs (creating links, redirecting, etc).

Open these files to see the functions they provide and their precise usage. You can also define your own helpers - see the [CodeIgniter documentation](https://www.codeigniter.com/userguide3/general/helpers.html).

**[Prev: Step 2, Authentication module](./step2.md)**
**[Next: Step 4, Contact list](./step4.md)**
