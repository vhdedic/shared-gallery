<?php

namespace App\Controller;

use App\Model\User;
use App\Core\View;
use App\Core\Validation;

/**
 * RegistrationController controller
 */
class RegistrationController
{
    /**
     * Redirect to home view if user logged
     * or render registration view with View model if user not logged
     *
     * @return string|object Redirect if user logged or not
     */
    function index()
    {
        // Check if user logged
        if (isset($_SESSION['username'])) {
            header('Location: /home/index/');
            exit();

        } else {

            // Call registerUser() for user registration
            User::registerUser();

            // Call View model
            $view = new View;

            $view->render('layout', 'registration', $args = [
                'notifications' => Validation::notifications(),
            ]);
        }
    }
}
