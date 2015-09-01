<?php
/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 30.08.2015
 * Time: 17:16
 */
//namespace App;

class Session
{
    public static function init()
    {
        if (session_id() == '')
            session_start();
    }

    public static function destroy()
    {
        session_destroy();
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
    }

    public static function add($key, $value)
    {
        $_SESSION[$key][] = $value;
    }

    public static function userIsLoggedIn()
    {
        return (self::get('user_logged_in') ? true : false);
    }
}