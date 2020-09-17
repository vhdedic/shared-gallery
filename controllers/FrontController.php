<?php

/**
 * FrontController controller
 */
class FrontController
{
    /**
     *  Constructor for FrontController
     */
    function __construct()
    {
        // Start session
        session_start();

        // Get controller prefix as $file and method as $action from query      string
        if($_SERVER['QUERY_STRING'] == ''){
            $file = 'home';
            $action = 'index';

        } else {
            $file = htmlspecialchars($_GET['page']);
            $action = htmlspecialchars($_GET['action']);
        }

        // Get complete controller filename
        $controller = ucfirst($file).'Controller';

        // If condition is true call controller->method() or if is false return error 404
        if (file_exists(CONTROLLERS.$controller.'.php') && method_exists($controller, $action)) {
            $controller = new $controller();
            $controller->$action();

        } else {
            header("HTTP/1.0 404 Not Found");
        }
    }
}
