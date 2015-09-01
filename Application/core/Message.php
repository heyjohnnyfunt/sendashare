<?php

/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 01.09.2015
 * Time: 23:34
 */
class Message
{
    private static $message = false;

    public static function get($key){
        if (!self::$message) {
            $config_file = dirname(realpath(__DIR__)) . '/config/messages.php';
            if (!file_exists($config_file)) {
                return false;
            }
            self::$message = require $config_file;
            if (!array_key_exists($key, self::$message)) {
                return false;
            }
        }
        return self::$message[$key];
    }
}