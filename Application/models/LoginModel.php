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

    public static function login($username, $password, $set_remember_me_cookie = null)
    {
        if (empty($username) OR empty($password)) {
            return false;
        }

        $result = self::validateUser($username, $password);

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

    private static function validateUser($username, $password)
    {
        if (Session::get('failed-login-count') >= 3 AND (Session::get('last-failed-login') > (time() - 30))) {
            Session::add(Message::get('LOGIN_FAILED'), Message::get('LOGIN_3_ATTEMPTS'));
            return false;
        }

        $result = UserModel::checkUser($username, $password);

//        var_dump($result);
        if ($result) {
            Session::set('failed-login-count', 0);
            Session::set('last-failed-login', '');
        } else {
            Session::set('failed-login-count', Session::get('failed-login-count') + 1);
            Session::set('last-failed-login', time());
            Session::add('feedback_negative', Message::get('LOGIN_3_ATTEMPTS'));
            return false;
        }

        if (($result['failed_login_count'] >= 3) AND ($result['last_failed_login'] > (time() - 30))) {
            Session::add(Message::get('LOGIN_FAILED'), Message::get('LOGIN_3_ATTEMPTS'));
            return false;
        }

        if ($result['active_user'] != 1) {
            Session::add(Message::get('LOGIN_FAILED'), Message::get('ACCOUNT_NOT_ACTIVATED'));
            return false;
        }

        if ($password != $result['password']) {
            self::incrementLoginFail($result['username']);
            Session::add(Message::get('LOGIN_FAILED'), Message::get('WRONG_PASSWORD'));
            return false;
        }

        return $result;
    }

    private static function incrementLoginFail($username)
    {
        $db = Database::getDb()->connect();
        if ($query = $db->prepare("UPDATE
                    users
                SET
                  failed_login_count = failed_login_count+1,
                  last_failed_login = ?
                WHERE
                  (username = ? OR email = ?) LIMIT 1")
        ) {
            $query->bind_param('sss',time(), $username, $username);
//            $params = array(time(), &$username, &$username);
//            call_user_func_array(array($query, "bind_param"), array_merge(array('sss'), $params));
            $query->execute();
            if($query->errno){
                Session::add(Message::get('LOGIN_FAILED'), Message::get('DB_ERROR'));
            }
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