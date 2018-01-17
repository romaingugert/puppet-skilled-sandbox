<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends \App\Core\Controller\Base
{
    protected $isPublic = true;

    protected $layout = 'simple';

    public function index()
    {
        $this->render();
    }
}
