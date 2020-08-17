<?php
/**
 *
 */
class HomeController
{
    function index()
    {
        $view = new View;
        $view->render('layout', 'home', $args = []);
    }
}
