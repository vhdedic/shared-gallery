<?php
/**
 *
 */
class LoginController
{
    function index()
    {
        User::loginUser();
        $view = new View;
        $view->render('layout', 'login', $args = []);
    }
}
