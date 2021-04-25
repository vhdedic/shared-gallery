<?php

namespace App\Model;

use App\Core\Database;

/**
 * Image model
 */
class Image
{
    /**
     * Upload image on management view
     *
     * @return object|string    If is image format valid or not
     */
    public function uploadImage()
    {
        // Check if isset ($_POST['upload'])
        if (isset($_POST['upload'])) {

            // Upload folder
            $upload = ROOT.'uploads/';

            // $_FILES['images']
            $filename = $_FILES['images']['name'];
            $type = $_FILES['images']['type'];
            $tmp_name = $_FILES['images']['tmp_name'];

            // Get username
            $username = $_SESSION['username'];

            if (empty($filename)) {
                array_push(Validation::$errors, 'Choose image before press Upload button');

            } elseif ($type == 'image/jpeg' || $type == 'image/png') {

                $path = pathinfo($filename);
                $extension = $path['extension'];
                $new_filename = date('U_').rand(100000, 999999).'.'.$extension;

                move_uploaded_file($tmp_name, $upload.$new_filename);

                $database = Database::getInstance();
                $sth = $database->prepare("INSERT INTO image (user_id, filename) VALUES ((SELECT id FROM user WHERE username = '$username'), '$new_filename')");

                $sth->execute();

            } else {
                array_push(Validation::$errors, 'Image type is wrong');
            }
        }
    }

    /**
     * Get images data from database for table on management view
     *
     * @return array $images
     */
    public function getImages()
    {
        $database = Database::getInstance();
        $sth = $database->prepare("SELECT image.id, image.filename, user.username, user.email FROM image INNER JOIN user ON user.id = image.user_id");

        $sth->execute();

        $images = $sth->fetchAll();

        return $images;
    }

    /**
     * Remove image in database and upload map
     *
     * @return void
     */
    public function imageRemove()
    {
        // Check if isset ($_POST['remove'])
        if (isset($_POST['remove'])) {

            $image_id = $_POST['id'];
            $image_name = $_POST['image'];

            $database = Database::getInstance();
            $sth = $database->prepare("DELETE FROM image WHERE id=$image_id");

            unlink(ROOT.'uploads/'.$image_name);

            $sth->execute();
        }
    }

    /**
     * Count images in database. Display on home view after ajax request.
     *
     * @return string   Number of images
     */
    public function countImages()
    {
        $database = Database::getInstance();
        $sth = $database->query('SELECT COUNT(filename) as count FROM image');

        $count = $sth->fetchColumn();

        echo $count;
    }

}
