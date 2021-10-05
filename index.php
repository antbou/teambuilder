<?php

use Teambuilder\core\Autologin;

require('vendor/autoload.php');

session_start();
Autologin::login();

$defaultControllerName = "HomeController";
$controllerName = null;

$task = 'index';
$defaultTask = "index";

if (!empty($_GET['controller'])) {
    $controllerName = ucfirst($_GET['controller']);
}

if (!empty($_GET['task'])) {
    $task = $_GET['task'];
}



$controllerName = "Teambuilder\controller\\" . $controllerName . 'Controller';

$controllerName = class_exists($controllerName) ? $controllerName : "Teambuilder\controller\\" . $defaultControllerName;

$controller = new $controllerName();
$controller->$task();
