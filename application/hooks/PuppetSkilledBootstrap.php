<?php
use \Globalis\PuppetSkilled\Core\Application;

class PuppetSkilledBootstrap
{
    public function boot()
    {
        $application = Application::getInstance();

        $container = $application->getContainer();

        // Language
        $container['languageService'] = function ($c) {
            return new \App\Service\Language\Language();
        };
    }
}
