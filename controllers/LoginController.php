<?php
/**
 *
 */
class LoginController
{
    function index()
    {
        if (isset($_SESSION['username'])){
            header('Location: '.Config::getParams('url').'index.php?page=home&action=index');
            exit();

        } else {

            User::loginUser();
            $view = new View;
            $view->render('layout', 'login', $args = []);
        }
    }

    function logout()
    {
        unset($_SESSION['username']);
        header('Location: '.Config::getParams('url').'index.php?page=login&action=index');
        exit();
    }
}
