<?php
/**
 *
 */
class ManagementController
{
    function index()
    {
        if (isset($_SESSION['username'])){
            Image::uploadImage();
            $view = new View;
            $view->render('layout', 'management', $args = [
                'images' => Image::getImages(),
            ]);

        } else {
            header('Location: '.Config::getParams('url').'index.php?page=login&action=index');
            exit();
        }
    }
}
