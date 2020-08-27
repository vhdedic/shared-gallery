<?php
/**
 *
 */
class RegistrationController
{
    function index()
    {
        if (isset($_SESSION['username']))
        {
            header('Location: '.Config::getParams('url').'index.php?page=home&action=index');
            exit();

        } else {
            User::registerUser();
            $view = new View;
            $view->render('layout', 'registration', $args = [
                'notifications' => Validation::notifications(),
            ]);
        }
    }
}
