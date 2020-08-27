<?php
/**
 *
 */
class User
{
    public static function registerUser()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $validation = new Validation;
            $validation->validate(array(
                'username' => array(
                    'required' => true,
                    'size_min' => 8,
                    'size_max' => 20,
                    'unique' => 'users'
                ),
                'email' => array(
                    'required' => true,
                    'size_max' => 40,
                    'email' => 'email',
                    'unique' => 'users'
                ),
                'password' => array(
                    'required' => true,
                    'size_min' => 8,
                    'confirm' => 'confirm_password'
                ),
                'confirm_password' => array(
                    'required' => true,
                    'confirm' => 'password'
                )
            ));

            if($validation->validate() == true){

                $sth = Database::getInstance()->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");

                $hashedpassword = password_hash($_POST['password'], PASSWORD_ARGON2I);

                // Bind parameters to statement
                $sth->bindParam(':username', $_POST['username']);
                $sth->bindParam(':email', $_POST['email']);
                $sth->bindParam(':password', $hashedpassword);

                // Execute the prepared statement
                $sth->execute();

                header('Location: '.Config::getParams('url').'index.php?page=login&action=index');
                exit();
            }
        }
    }

    public static function loginUser()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $sth = Database::getInstance()->prepare("SELECT id, username, password FROM users WHERE username = :username");

            $sth->bindValue(':username', $_POST['username']);

            $sth->execute();

            $userdata = $sth->fetch();

            if(!empty($_POST["remember_me"])){
                setcookie ("remember_username",$_POST["username"],time()+ 1296000);
            }

            if (password_verify($_POST['password'], $userdata['password'])){

                $_SESSION['username'] = $userdata['username'];

                header('Location: '.Config::getParams('url').'index.php?page=management&action=index');
                exit();
            }
        }
    }

    public static function changePassword()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $username = $_SESSION['username'];

            $sth_old = Database::getInstance()->query("SELECT password FROM users WHERE username = '$username'");
            $sth_old->execute();

            $old_password = $sth_old->fetchColumn();

            $sth_new = Database::getInstance()->prepare("UPDATE users SET password = :new_password WHERE username = '$username'");

            if (password_verify($_POST['old_password'], $old_password)) {

                $hashednewpassword = password_hash($_POST['new_password'], PASSWORD_ARGON2I);

                $sth_new->bindParam(':new_password', $hashednewpassword);

                $sth_new->execute();

                header('Location: '.Config::getParams('url').'index.php?page=login&action=logout');
                exit;
            }
        }
    }

    public static function removeAccount()
    {
        if(isset($_POST['remove_account'])){

            $username = $_SESSION['username'];

            $sth = Database::getInstance()->prepare("SELECT image FROM images WHERE user_id = (SELECT id FROM users WHERE username = '$username')");

            $sth->execute();
            $images = $sth->fetchAll();

            foreach ($images as $image) {
                unlink(ROOT.'uploads/'.$image['image']);
            }

            $sth_del = Database::getInstance()->prepare("DELETE FROM users WHERE username = '$username'");
            $sth_del->execute();

            header('Location: '.Config::getParams('url').'index.php?page=login&action=logout');
            exit;
        }
    }
}
