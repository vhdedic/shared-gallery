<?php
/**
 *
 */
class Image
{
    public static function uploadImage()
    {
        if(isset($_POST['upload'])){

            $upload = ROOT.'uploads/';

            $filename = $_FILES['images']['name'];
            $type = $_FILES['images']['type'];
            $tmp_name = $_FILES['images']['tmp_name'];
            $username = $_SESSION['username'];

            if ($type == 'image/jpeg' || $type == 'image/png') {
                $path = pathinfo($filename);
                $extension = $path['extension'];
                $new_filename = date('U_').rand(100000, 999999).'.'.$extension;

                move_uploaded_file($tmp_name, $upload.$new_filename);

                $sth = Database::getInstance()->prepare("INSERT INTO images (user_id, image) VALUES ((SELECT id FROM users WHERE username = '$username'), '$new_filename')");

                $sth->execute();
            }
        }
    }

    public static function getImages()
    {
        $sth = Database::getInstance()->prepare("SELECT images.id, images.image, users.username, users.email FROM images INNER JOIN users ON users.id = images.user_id");

        $sth->execute();

        $images = $sth->fetchAll();

        return $images;
    }

    public static function imageRemove()
    {
        if(isset($_POST['remove'])){

            $image_id = $_POST['id'];
            $image_name = $_POST['image'];

            $sth = Database::getInstance()->prepare("DELETE FROM images WHERE id=$image_id");

            unlink(ROOT.'uploads/'.$image_name);

            $sth->execute();
        }
    }
}
