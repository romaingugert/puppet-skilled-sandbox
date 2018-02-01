<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Miscellaneous extends \Globalis\PuppetSkilled\Controller\Base
{
    protected $layout = 'simple';

    /**
     * 404 Error
     */
    public function not_found()
    {
        $this->output->set_status_header(404);
        $this->render(['page_title' => 'lang:general_title_not_found'], 'error/404');
    }
}
