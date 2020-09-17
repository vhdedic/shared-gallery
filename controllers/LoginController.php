<?php

/**
 * LoginController controller
 */
class LoginController
{
    /**
     * Redirect to home view if user logged
     * or render login view with View model if user not logged
     *
     * @return string|object Redirect if user logged or not
     */
    function index()
    {
        // Check if user logged
        if (isset($_SESSION['username'])){
            header('Location: '.Config::getParams('url').'index.php?page=home&action=index');
            exit();

        } else {

            // Call loginUser() for login user
            User::loginUser();

            // Call View model
            $view = new View;

            $view->render('layout', 'login', $args = [
                // Get $notifications
                'notifications' => Validation::notifications(),
            ]);
        }
    }

    /**
     * Logout user and redirect to login
     *
     * @return string login view
     */
    function logout()
    {
        unset($_SESSION['username']);

        header('Location: '.Config::getParams('url').'index.php?page=login&action=index');
        exit();
    }
}
