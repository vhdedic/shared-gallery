<?php

// define base path
define('ROOT', __DIR__ . '/');
define('MODELS', ROOT.'models/');
define('VIEWS', ROOT.'views/');
define('CONTROLLERS', ROOT.'controllers/');

// enable error_reporting
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

// set include path
set_include_path(implode(PATH_SEPARATOR, array(
    MODELS,
    CONTROLLERS,
)));

// register autoloader
spl_autoload_register(function($class) {
    $classPath = strtr($class, '\\', DIRECTORY_SEPARATOR) . '.php';
    return include $classPath;
});

// run app
new FrontController();
