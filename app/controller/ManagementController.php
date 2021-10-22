<?php

namespace App\Controller;

use App\Core\View;
use App\Model\Image;
use App\Core\Validation;

/**
 * ManagementController controller
 */
class ManagementController
{
    /**
     * Render management view with View model if user logged
     * or redirect to login view if user not logged
     *
     * @return object|string Redirect if user logged or not
     */
    function index()
    {
        if (isset($_SESSION['username'])) {

            $img = new Image;
            $img->uploadImage();

            $view = new View;
            $view->render('layout', 'management', $args = [
                'images' => $img->getImages(),
                'notifications' => Validation::notifications(),
            ]);

        } else {
            header('Location: /login/index/');
            exit();
        }
    }

    /**
     * Remove image
     *
     * @return string management view
     */
    function remove()
    {
        $image = new Image;
        $image->imageRemove();

        header('Location: /management/index/');
        exit();
    }
}
