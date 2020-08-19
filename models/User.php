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

            header('Location: '.Config::getParams('url').'index.php?page=login&action=index');
            exit();
        }
    }

    public static function loginUser()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $stmt = Database::getInstance()->prepare("SELECT id, username, password FROM users WHERE username = :username");

            $stmt->bindValue(':username', $_POST['username']);

            $stmt->execute();

            $userdata = $stmt->fetch();

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
}
