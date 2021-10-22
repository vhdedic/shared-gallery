<?php

namespace App\Controller;

use App\Core\View;
use App\Model\User;
use App\Core\Validation;
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
        if (isset($_SESSION['username'])) {
            header('Location: /home/index/');
            exit();

        } else {

            $user = new User;
            $user->loginUser();

            $view = new View;

            $view->render('layout', 'login', $args = [
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
        header('Location: /login/index/');
        exit();
    }
}
