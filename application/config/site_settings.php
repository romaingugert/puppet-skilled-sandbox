<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config['site_settings'] = [
    // Site name
    'name' => 'Puppet Skilled',
    // Default page title
    'title' => 'Puppet Skilled',
    // Multilingual settings (set empty array to disable this)
    'multilingual' => [
        'default'       => 'fr',
        'available'     => [
            'en'        => [
                'label' => 'EN', // label to be displayed on language switcher
                'value' => 'english', // to match with CodeIgniter folders inside application/language/
                'local' => ['en_US.UTF8', 'en.UTF8'],
            ],
            'fr' => [
                'label' => 'FR',
                'value' => 'french',
                'local' => ['fr_FR.UTF8', 'fr.UTF8'],
            ]
        ],
        'autoload' => ['general'],
    ],
];
