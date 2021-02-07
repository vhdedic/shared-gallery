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
        // Check if $_SERVER['REQUEST_METHOD'] == 'POST'
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Call Validation model
            $validation = new Validation;

            // Validate register form
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

            // Execute query if validation pass
            if ($validation->validate() == true) {

                $sth = Database::getInstance()->prepare("INSERT INTO user (username, email, password) VALUES (:username, :email, :password)");

                // Hashing password before store to database
                $hashedpassword = password_hash($_POST['password'], PASSWORD_ARGON2I);

                $sth->bindParam(':username', $_POST['username']);
                $sth->bindParam(':email', $_POST['email']);
                $sth->bindParam(':password', $hashedpassword);

                $sth->execute();

                // Redirect to login page after registration
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
        // Check if $_SERVER['REQUEST_METHOD'] == 'POST'
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Call Validation model
            $validation = new Validation;

            // Validate login form
            $validation->validate(array(
                'username' => array(
                    'required' => true
                ),
                'password' => array(
                    'required' => true
                )
            ));

            // Execute query if validation pass
            if ($validation->validate() == true) {

                $sth = Database::getInstance()->prepare("SELECT id, username, password FROM user WHERE username = :username");

                $sth->bindValue(':username', $_POST['username']);

                $sth->execute();

                $userdata = $sth->fetch();

                // Store "remember_username" cookie if $_POST["remember_me"] is checked
                if(!empty($_POST["remember_me"])){
                    setcookie ("remember_username",$_POST["username"],time()+ 1296000);
                }

                // Check username and password
                if(empty($userdata)){
                    array_push(Validation::$errors, 'Access denied');

                } elseif (password_verify($_POST['password'], $userdata['password'])){

                    // Get username
                    $_SESSION['username'] = $userdata['username'];

                    // Redirect to management page after login
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
        // Check if $_SERVER['REQUEST_METHOD'] == 'POST'
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Call Validation model
            $validation = new Validation;

            // Validate change password form
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

            // Execute queries if validation pass
            if ($validation->validate() == true) {

                // Get username
                $username = $_SESSION['username'];

                // Get old password from database
                $sth_old = Database::getInstance()->query("SELECT password FROM user WHERE username = '$username'");
                $sth_old->execute();

                $old_password = $sth_old->fetchColumn();

                // Change password
                $sth_new = Database::getInstance()->prepare("UPDATE user SET password = :new_password WHERE username = '$username'");

                // Old password verify
                if (password_verify($_POST['old_password'], $old_password)) {

                    // Hashing new password before store to database
                    $hashednewpassword = password_hash($_POST['new_password'], PASSWORD_ARGON2I);

                    $sth_new->bindParam(':new_password', $hashednewpassword);

                    $sth_new->execute();

                    // Logout user after change password
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
        // Check if isset $_POST['remove_account'])
        if(isset($_POST['remove_account'])){

            // Get username
            $username = $_SESSION['username'];

            // Remove user images from database
            $sth = Database::getInstance()->prepare("SELECT image FROM images WHERE user_id = (SELECT id FROM user WHERE username = '$username')");

            $sth->execute();

            $images = $sth->fetchAll();

            // Remove user images from upload map
            foreach ($images as $image) {
                unlink(ROOT.'uploads/'.$image['image']);
            }

            // Remove user account in database
            $sth_del = Database::getInstance()->prepare("DELETE FROM user WHERE username = '$username'");

            $sth_del->execute();

            // Logout removed user account
            header('Location: /login/logout/');
            exit;
        }
    }
}
