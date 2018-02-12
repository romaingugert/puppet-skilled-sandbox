# Step 4

**[Prev: Step 3, Profile editing and language selection](./step3.md)**
**[Next: Step 5, Users and companies backoffice](./step5.md)**

This step adds a contact list module which lists the users of the platform. It uses two Puppet Skilled libraries :

### QueryFilter

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


### QueryPager

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


**[Prev: Step 3, Profile editing and language selection](./step3.md)**
**[Next: Step 5, Users and companies backoffice](./step5.md)**
