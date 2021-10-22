<?php

namespace App\Model;

use App\Core\Validation;
use App\Core\Database;

/**
 * User model
 */
class User
{
    /**
     * Register user
     *
     * @return string|false If validation passed or not
     */
    public function registerUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $validation = new Validation;

            $validation->validate(array(
                'username' => array(
                    'required' => true,
                    'size_min' => 8,
                    'size_max' => 20,
                    'unique' => 'user'
                ),
                'email' => array(
                    'required' => true,
                    'size_max' => 40,
                    'email' => 'email',
                    'unique' => 'user'
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

            if ($validation->validate() == true) {

                $database = Database::getInstance();
                $sth = $database->prepare("INSERT INTO user (username, email, password) VALUES (:username, :email, :password)");

                $hashedpassword = password_hash($_POST['password'], PASSWORD_ARGON2I);

                $sth->bindParam(':username', $_POST['username']);
                $sth->bindParam(':email', $_POST['email']);
                $sth->bindParam(':password', $hashedpassword);

                $sth->execute();

                header('Location: /login/index/');
                exit();
            }
        }
    }

    /**
     * User login
     *
     * @return string|string If validation passed or not
     */
    public function loginUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $validation = new Validation;

            $validation->validate(array(
                'username' => array(
                    'required' => true
                ),
                'password' => array(
                    'required' => true
                )
            ));

            if ($validation->validate() == true) {

                $database = Database::getInstance();
                $sth = $database->prepare("SELECT id, username, password FROM user WHERE username = :username");

                $sth->bindValue(':username', $_POST['username']);

                $sth->execute();

                $userdata = $sth->fetch();

                if(!empty($_POST["remember_me"])){
                    setcookie ("remember_username",$_POST["username"],time()+ 1296000);
                }

                if(empty($userdata)){
                    array_push(Validation::$errors, 'Access denied');

                } elseif (password_verify($_POST['password'], $userdata['password'])){

                    $_SESSION['username'] = $userdata['username'];

                    header('Location: /management/index/');
                    exit();

                } else {
                    array_push(Validation::$errors, 'Access denied');
                }
            }
        }
    }

    /**
     * Change user password
     *
     * @return string|string If validation passed or not
     */
    public function changePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $validation = new Validation;

            $validation->validate(array(
                'old_password' => array(
                    'required' => true
                ),
                'new_password' => array(
                    'required' => true,
                    'size_min' => 8,
                    'confirm' => 'confirm_new_password'
                ),
                'confirm_new_password' => array(
                    'required' => true,
                    'confirm' => 'new_password'
                ),
            ));

            if ($validation->validate() == true) {

                $username = $_SESSION['username'];

                $database = Database::getInstance();
                $sth_old = $database->query("SELECT password FROM user WHERE username = '$username'");
                $sth_old->execute();

                $old_password = $sth_old->fetchColumn();

                $sth_new = $database->prepare("UPDATE user SET password = :new_password WHERE username = '$username'");

                if (password_verify($_POST['old_password'], $old_password)) {

                    $hashednewpassword = password_hash($_POST['new_password'], PASSWORD_ARGON2I);

                    $sth_new->bindParam(':new_password', $hashednewpassword);

                    $sth_new->execute();

                    header('Location: /login/logout/');
                    exit;

                } else {
                    array_push(Validation::$errors, 'Old password is wrong');
                }
            }
        }
    }

    /**
     * Remove user account and user images from database and upload map
     *
     * @return string login view
     */
    public function removeAccount()
    {
        if(isset($_POST['remove_account'])){

            $username = $_SESSION['username'];

            $database = Database::getInstance();
            $sth = $database->prepare("SELECT image FROM images WHERE user_id = (SELECT id FROM user WHERE username = '$username')");

            $sth->execute();

            $images = $sth->fetchAll();

            foreach ($images as $image) {
                unlink(ROOT.'uploads/'.$image['image']);
            }

            $database = Database::getInstance();
            $sth_del = $database->prepare("DELETE FROM user WHERE username = '$username'");

            $sth_del->execute();

            header('Location: /login/logout/');
            exit;
        }
    }
}
