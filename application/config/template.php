<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config['default'] = $config['empty'] = $config['simple'] = [
    "style_autoload" => [
        'main',
    ],
    "script_autoload" => [
        'vendor',
        'main'
    ],
    'html_style_path' => 'public/styles',
    'html_script_path' => 'public/scripts',
    'html_image_path' => 'public/images',
];
