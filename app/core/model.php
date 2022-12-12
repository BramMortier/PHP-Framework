<?php 

class Model 
{
    public function db_connect()
    {
        try {
            $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
            $db = new PDO($dsn, DB_USER, DB_PASS);
            return $db;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}