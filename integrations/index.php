<?php
require '_helpers.php';
$view = isset($_GET['view']) && is_file('templates/'.$_GET['view'].'.php') ? $_GET['view'] : 'home';
view('templates/'.$view, ['current' => $view]);
?>
