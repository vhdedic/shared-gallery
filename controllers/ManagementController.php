<?php
/**
 *
 */
class ManagementController
{
    function index()
    {
        if (isset($_SESSION['username'])){
            $view = new View;
            $view->render('layout', 'management', $args = []);

        } else {
            header('Location: '.Config::getParams('url').'index.php?page=login&action=index');
            exit();
        }
    }
}
