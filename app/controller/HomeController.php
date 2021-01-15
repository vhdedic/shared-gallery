<?php

/**
 * HomeController controller
 */
class HomeController
{
    /**
     * Render home view with View model
     *
     * @return object home view
     */
    function index()
    {
        // Call View model
        $view = new View;

        $view->render('layout', 'home', $args = []);
    }

    /**
     * Number of images for Images button
     *
     * @return void  Call method
     */
    function images()
    {
        Image::countImages();
    }
}
