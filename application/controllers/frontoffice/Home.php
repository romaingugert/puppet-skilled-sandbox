<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends \App\Core\Controller\FrontOffice
{
    protected $autoload = [];

    public function index()
    {
        $this->render();
    }
}
