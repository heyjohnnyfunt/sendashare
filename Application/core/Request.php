<?php
/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 30.08.2015
 * Time: 12:42
 */

//namespace App;

class Request
{
    public static function get_get($key){
        return isset($_GET[$key]) ? $_GET[$key] : NULL;
    }

    public static function get_cookie($key)
    {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : NULL;
    }
}