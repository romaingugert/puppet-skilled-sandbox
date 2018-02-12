# Step 1

**[Next: Step 2, Authentication module](./step2.md)**


This step provide a basic architecture for the application with a single static page to present the main principles of Puppet Skilled.

## Configuration

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


## Controllers

Controllers are classes extending `\Globalis\PuppetSkilled\Controller\Base` and located in the `application/controllers` folder. They can be used the same way as [CodeIgniter controllers](https://www.codeigniter.com/userguide3/general/controllers.html).

For now, only two controllers are defined :

* `Welcome.php` : a very simple controller with a single `index` method,
* `Miscellaneous.php` : a controller handling 404 errors.


## Views

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


## Debug bar

Puppet Skilled provides developers with a debug bar, using the CodeIgniter [profiler](https://www.codeigniter.com/userguide3/general/profiling.html) and [benchmark](https://www.codeigniter.com/userguide3/libraries/benchmark.html) libraries. The profiler library is extended in `application/library/APP_Profiler.php`, and the DebugBar cell is in `application/views/Cell`.

The debug bar is displayed at the top of the page (it unfolds when the little red bug is clicked), and gives you access to useful pieces of information :

* Execution time,
* Memory usage,
* GET, POST and SESSION variables,
* Configuration variables,
* HTTP headers,
* SQL requests.

You can activate it by adding `$this->output->enable_profiler(true)` before calling the `render` method in your controllers.

**[Next: Step 2, Authentication module](./step2.md)**
