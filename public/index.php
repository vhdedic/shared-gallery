<?php

// define base path
define('ROOT', dirname(dirname(__FILE__)).'/');
define('MODELS', ROOT.'app/model/');
define('VIEWS', ROOT.'app/view/');
define('CONTROLLERS', ROOT.'app/controller/');
define('CORE', ROOT.'app/core/');

// enable error_reporting
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

// set include path
set_include_path(implode(PATH_SEPARATOR, array(
    MODELS,
    CONTROLLERS,
    CORE,
)));

// register autoloader
spl_autoload_register(function($class) {
    $classPath = strtr($class, '\\', DIRECTORY_SEPARATOR) . '.php';
    return include $classPath;
});

// run app
new FrontController();
