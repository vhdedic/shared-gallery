<?php

/**
 * MyaccountController controller
 */
class MyaccountController
{
    /**
     * Render myaccount view with View model if user logged
     * or redirect to login view if user not logged
     *
     * @return object|string Redirect if user logged or not
     */
    function index()
    {
        // Check if user logged
        if (isset($_SESSION['username'])){

            // Call changePassword() for change user password
            User::changePassword();

            // Call View model
            $view = new View;

            $view->render('layout', 'myaccount', $args = [
                // Get $notifications
                'notifications' => Validation::notifications(),
            ]);

        } else {
            header('Location: '.Config::getParams('url').'index.php?page=login&action=index');
            exit();
        }
    }

    /**
     * Remove user in database
     *
     * @return void Call method
     */
    function remove()
    {
        // Call removeAccount() for remove user account
        User::removeAccount();
    }
}
