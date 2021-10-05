<?php

use Teambuilder\core\Autologin;

require('vendor/autoload.php');

session_start();
Autologin::login();

$controllerName = "HomeController";
$task = "index";

if (!empty($_GET['controller'])) {
    $controllerName = ucfirst($_GET['controller']);
}

if (!empty($_GET['task'])) {
    $task = $_GET['task'];
}

$controllerName = "Teambuilder\controller\\" . $controllerName;

$controller = new $controllerName();
$controller->$task();
