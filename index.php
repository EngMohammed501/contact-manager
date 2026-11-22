<?php
session_start();

require __DIR__ . '/config/database.php';

$controller = $_GET['controller'] ?? 'contact';
$action     = $_GET['action'] ?? 'index';

$controllerName = ucfirst($controller) . 'Controller';
$file = __DIR__ . '/controllers/' . $controllerName . '.php';

if (!preg_match('/^[a-z]+$/', $controller) || !file_exists($file)) {
    http_response_code(404);
    exit('Page not found');
}

require $file;

$obj = new $controllerName();

if (!method_exists($obj, $action)) {
    http_response_code(404);
    exit('Page not found');
}

$obj->$action();