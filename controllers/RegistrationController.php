<?php
/**
 *
 */
class RegistrationController
{
    function index()
    {
        User::registerUser();
        $view = new View;
        $view->render('layout', 'registration', $args = []);
    }
}
