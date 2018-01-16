<?php
use \Globalis\PuppetSkilled\View\View;
$view = new View((isset($_SESSION['last_layout'])? $_SESSION['last_layout'] : 'empty'));
$view->set(['heading' => $heading, 'message' => $message]);
echo $view->render('error/general');
