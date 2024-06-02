<?php

require "..\config\config.php";

class DataBase
{
    public static function OpenConnection()
    {
        $dbName = Config::DATABASE_NAME;
        $connection = new PDO("mysql:host=".$_SERVER['SERVER_NAME'].";dbname=".$dbName, Config::USER, Config::PASSWORD);
        // set the PDO error mode to exception
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    }
}
