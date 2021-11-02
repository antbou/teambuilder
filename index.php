<?php

use Teambuilder\core\service\Http;
use Teambuilder\core\service\Authenticator;

require('vendor/autoload.php');

session_start();
Authenticator::autologin();

$controller = 'Home';
$task = 'index';

$controller = (empty($_GET['controller'])) ? $controller : ucfirst($_GET['controller']);
$task = (empty($_GET['task'])) ? $task : lcfirst($_GET['task']);

$controller = ("Teambuilder\controller\\" . $controller . 'Controller');

if (!class_exists($controller) || !method_exists($controller, $task)) {
    Http::notFoundException();
}
$controller = new $controller();
$controller->$task();
