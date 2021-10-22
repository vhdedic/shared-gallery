<?php

namespace App\Controller;

use App\Core\View;
use App\Model\User;
use App\Core\Validation;

/**
 * MyAccountController controller
 */
class MyAccountController
{
    /**
     * Render myaccount view with View model if user logged
     * or redirect to login view if user not logged
     *
     * @return object|string Redirect if user logged or not
     */
    function index()
    {
        if (isset($_SESSION['username'])) {

            $user = new User;
            $user->changePassword();

            $view = new View;
            $view->render('layout', 'myAccount', $args = [
                'notifications' => Validation::notifications(),
            ]);

        } else {
            header('Location: /login/index/');
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
        $user = new User;
        $user->removeAccount();
    }
}
