<?php

class Database

{
    private static $dbHost = "localhost";
    private static $dbName = "animaleries";
    private static $dbUser = "root";
    private static $dbUserPaasword = "";

    private static $connection = null;


    public static function connect()
    {
        try{
            self::$connection = new PDO("mysql:host=" . self::$dbHost . ";dbname=" .
             self::$dbName,self::$dbUser,self::$dbUserPaasword);
            }
        catch(PDOException $e)
        {
            die('ERROR:' .$e->getMessage());
        }
        return self::$connection;
    }

    public static function disconnect()
    {
        self::$connection = null;
    }

}

Database::connect();


?>