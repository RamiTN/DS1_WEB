<?php
// index.php - Front Controller

// Load config
require_once __DIR__ . '/config/config.php';

// Default controller/action
$controller = $_GET['controller'] ?? 'User';
$action = $_GET['action'] ?? 'login';

// Build controller file path
$controllerName = $controller . 'Controller';
$controllerFile = __DIR__ . '/app/controllers/' . $controllerName . '.php';

// Check if controller exists
if (file_exists($controllerFile)) {
    require_once $controllerFile;

    // Instantiate controller
    if (class_exists($controllerName)) {
        $c = new $controllerName();

        // Call action if exists
        if (method_exists($c, $action)) {
            $c->$action();
        } else {
            die("Action '$action' not found in controller '$controllerName'");
        }
    } else {
        die("Controller class '$controllerName' not found");
    }
} else {
    die("Controller file '$controllerFile' not found");
}