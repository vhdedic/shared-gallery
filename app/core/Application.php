<?php

namespace App\Core;

/**
 * Application model
 */
class Application
{
    function run()
    {
        // Start session
        session_start();

        // Get controller prefix as $file and method as $action from REQUEST_URI
        if ($_SERVER["REQUEST_URI"] == '/'){

            $file = 'home';
            $action = 'index';

        } else {

            $path = trim($_SERVER["REQUEST_URI"], DIRECTORY_SEPARATOR);
            $parts = explode(DIRECTORY_SEPARATOR, $path);

            $file = htmlspecialchars($parts[0]);
            $action = htmlspecialchars($parts[1]);
        }

        $controller = ucfirst($file).'Controller';
        $class = "App\\Controller\\$controller";

        if (!method_exists($class, $action)) {

            header("HTTP/1.0 404 Not Found");
            exit();
        }

        $object = new $class();
        $object->$action();
    }
}
