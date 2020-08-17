<?php
/**
 *
 */
class User
{
    public static function registerUser()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $sth = Database::getInstance()->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");

            $hashedpassword = password_hash($_POST['password'], PASSWORD_ARGON2I);

            // Bind parameters to statement
            $sth->bindParam(':username', $_POST['username']);
            $sth->bindParam(':email', $_POST['email']);
            $sth->bindParam(':password', $hashedpassword);

            // Execute the prepared statement
            $sth->execute();
            /*
            header('Location: '.Config::getParams('url').'index.php?page=login&action=index');
            exit();
            */
        }
    }
}
