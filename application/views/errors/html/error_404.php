<?php
use \Globalis\PuppetSkilled\View\View;
$view = new View('empty');
$view->set(['heading' => $heading, 'message' => $message]);
echo $view->render('error/404');
