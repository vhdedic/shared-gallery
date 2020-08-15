<?php
/**
 *
 */
class Database
{
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        $dbhost = Config::getParams('db_host');
        $dbname = Config::getParams('db_name');
        $dbchar = Config::getParams('db_charset');
        $dbuser = Config::getParams('db_user');
        $dbpass = Config::getParams('db_password');

        try {
            $this->conn = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=$dbchar", $dbuser, $dbpass);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getInstance()
    {
        if(!isset(self::$instance)){
            self::$instance = new Database();
        }

        // get connection
        return self::$instance->conn;
    }
}
