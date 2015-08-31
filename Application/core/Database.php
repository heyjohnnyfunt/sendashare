<?php

/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 31.08.2015
 * Time: 22:43
 */
class Database
{
    private static $dataBase;
    private $connection;

    public static function getDb(){
        if(!self::$dataBase)
            self::$dataBase = new Database();
        return self::$dataBase;
    }

    public function connect(){
        if(!$this->connection){
            $this->connection = new mysqli(
                Config::get('DB_HOST'),
                Config::get('DB_USER'),
                Config::get('DB_PASS'),
                Config::get('DB_NAME')
            );
        }
        return $this->connection;
    }
}