<?php
/**
 *
 */
class FrontController
{
    function __construct()
    {
        // start session
        session_start();
        // get file and action
        if($_SERVER['QUERY_STRING'] == ''){
            $file = 'home';
            $action = 'index';
        }
        else{
            $file = htmlspecialchars($_GET['page']);
            $action = htmlspecialchars($_GET['action']);
        }

        // get controller class
        $controller = ucfirst($file).'Controller';
        $controller = new $controller();
        $controller->$action();
    }
}
