<?php

use Teambuilder\core\service\Http;
use Teambuilder\core\service\Authenticator;

require('vendor/autoload.php');

session_start();

Authenticator::autologin();

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

if (!method_exists($controller, $task)) {
    Http::notFoundException();
} else {
    $controller->$task();
}
