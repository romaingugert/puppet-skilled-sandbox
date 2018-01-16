<?php
(defined('BASEPATH')) or exit('No direct script access allowed');

class APP_Profiler extends CI_Profiler
{
    /**
     * Run the Profiler
     *
     * @return string
     */
    public function run()
    {
        $view = new \Globalis\PuppetSkilled\View\View();
        return $view->cell('DebugBar::display');
    }
}
