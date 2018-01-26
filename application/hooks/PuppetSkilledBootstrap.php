<?php
use \Globalis\PuppetSkilled\Core\Application;

class PuppetSkilledBootstrap
{
    public function boot()
    {
        $application = Application::getInstance();

        $container = $application->getContainer();
    }
}
