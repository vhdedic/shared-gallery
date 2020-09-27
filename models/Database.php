<?php

/**
 * Database model
 */
class Database
{
    /**
     * Database connection instance
     *
     * @var object
     */
    private static $instance = null;

    /**
     * Database connection
     *
     * @var object
     */
    private $conn;

    /**
     * Constructor for Database model
     */
    private function __construct()
    {
        /**
         * Database host name
         *
         * @var string
         */
        $dbhost = Config::getParams('db_host');

        /**
         * Database name
         *
         * @var string
         */
        $dbname = Config::getParams('db_name');

        /**
         * Character set
         *
         * @var string
         */
        $dbchar = Config::getParams('db_charset');

        /**
         * Database username
         *
         * @var string
         */
        $dbuser = Config::getParams('db_user');

        /**
         * Database password
         *
         * @var string
         */
        $dbpass = Config::getParams('db_password');

        // Create database if not exist
        try {
            $dbconn = new PDO("mysql:host=$dbhost;charset=$dbchar", $dbuser, $dbpass);

            $sql =
                "CREATE DATABASE IF NOT EXISTS ".$dbname." CHARACTER SET utf8 COLLATE utf8_general_ci;
                USE ".$dbname.";"
                .file_get_contents(ROOT.'config/database.sql');

            $dbconn->exec($sql);

        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        // Connect to database
        try {
            $this->conn = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=$dbchar", $dbuser, $dbpass);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Get instance of connection
     *
     * @return object
     */
    public static function getInstance()
    {
        if(!isset(self::$instance)){
            self::$instance = new Database();
        }

        // Get connection
        return self::$instance->conn;
    }
}
