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
}
