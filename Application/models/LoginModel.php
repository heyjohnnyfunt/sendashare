<?php

/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 31.08.2015
 * Time: 22:35
 */
require_once 'UserModel.php';

class LoginModel
{
    public static function isLoggedIn()
    {
        return Session::userIsLoggedIn();
    }

    public static function login($user_name, $user_password, $set_remember_me_cookie = null)
    {
        if (empty($user_name) OR empty($user_password)) {
            return false;
        }

        $result = UserModel::checkUser($user_name, $user_password);
        if (!$result) {
            return false;

        } else {
            Session::set('user_logged_in', true);
            /*foreach ($result as $key) {
                echo '<p>' . $key . '</p>';
            }*/
            return true;
        }
    }

    public static function logout()
    {
        self::deleteCookie();
        Session::destroy();
    }

    public static function deleteCookie()
    {
        setcookie('remember_me', false, time() - (3600 * 24 * 3650), Config::get('COOKIE_PATH'));
    }
}