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
}
