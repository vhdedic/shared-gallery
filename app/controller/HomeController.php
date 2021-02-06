<?php

namespace App\Controller;

use App\Core\View;
use App\Model\Image;

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


        $view = new View;

        $view->render('layout', 'home', $args = []);


        //$test = new Test;
        //$test->checkInclude();

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
