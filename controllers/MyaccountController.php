<?php
/**
 *
 */
class MyaccountController
{
    function index()
    {
        if (isset($_SESSION['username'])){
            $view = new View;
            $view->render('layout', 'myaccount', $args = []);

        } else {
            header('Location: '.Config::getParams('url').'index.php?page=login&action=index');
            exit();
        }
    }
}
