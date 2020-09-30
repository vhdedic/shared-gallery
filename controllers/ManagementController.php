<?php

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
        // Check if user logged
        if (isset($_SESSION['username'])) {

            // Call uploadImage() for image upload
            Image::uploadImage();

            // Call View model
            $view = new View;

            $view->render('layout', 'management', $args = [
                'images' => Image::getImages(),
                'notifications' => Validation::notifications(),
            ]);

        } else {
            header('Location: '.Config::getParams('url').'index.php?page=login&action=index');
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
        // Call imageRemove() for remove image in database and upload map
        Image::imageRemove();

        header('Location: '.Config::getParams('url').'index.php?page=management&action=index');
        exit();
    }
}
