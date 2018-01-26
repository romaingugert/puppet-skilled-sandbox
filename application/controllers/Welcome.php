<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends \Globalis\PuppetSkilled\Controller\Base
{
    protected $isPublic = true;

    protected $layout = 'simple';

    public function index()
    {
        $this->render();
    }
}
