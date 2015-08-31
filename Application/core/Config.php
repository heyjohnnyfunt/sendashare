<?php
/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 30.08.2015
 * Time: 12:31
 */

//namespace App;

class Config
{
    private static $config = false;

    public static function get($key)
    {
        if (!self::$config) {
            $config_file = dirname(realpath(__DIR__)) . '/config/config.php';
            if (!file_exists($config_file)) {
                return false;
            }
            self::$config = require $config_file;
        }
        return self::$config[$key];
    }
}