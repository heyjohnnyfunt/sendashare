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

    public static function login($username, $password, $remember_me_cookie = null)
    {
        if (empty($username) OR empty($password)) {
            return false;
        }

        $result = self::validateUser($username, $password);

        if (!$result) {
            Session::add(Message::get('LOGIN_FAILED'), Message::get('NO_USER'));
            return false;
        }

        Session::set('user_logged_in', true);

        if ($result['failed_login_count'] > 0) {
            self::resetLoginFail($result['username']);
        }

        if ($remember_me_cookie) {
            self::rememberMe($result['id']);
        }

        self::setSessionProperties($result['id'], $result['username'], $result['email']);

        return true;

    }

    private static function validateUser($username, $password)
    {
        if (Session::get('failed_login_count') >= 3 AND (Session::get('last_failed_login') > (time() - 30))) {
            Session::add(Message::get('LOGIN_FAILED'), Message::get('LOGIN_3_ATTEMPTS'));
            return false;
        }

        $result = UserModel::checkUser($username);

        if ($result) {
            Session::set('failed_login_count', 0);
            Session::set('last_failed_login', '');
        } else {
            Session::set('failed_login_count', Session::get('failed_login_count') + 1);
            Session::set('last_failed_login', time());
            Session::add('feedback_negative', Message::get('LOGIN_3_ATTEMPTS'));
            return false;
        }

        if (($result['failed_login_count'] >= 3) AND ($result['last_failed_login'] > (time() - 30))) {
            Session::add(Message::get('LOGIN_FAILED'), Message::get('LOGIN_3_ATTEMPTS'));
            return false;
        }

        /*if ($result['active_user'] != 1) {
            Session::add(Message::get('LOGIN_FAILED'), Message::get('ACCOUNT_NOT_ACTIVATED'));
            return false;
        }*/

        if (!password_verify($password, $result['password'])) {
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
            $query->bind_param('sss', time(), $username, $username);
//            $params = array(time(), &$username, &$username);
//            call_user_func_array(array($query, "bind_param"), array_merge(array('sss'), $params));
            $query->execute();
            if ($query->errno) {
                Session::add(Message::get('LOGIN_FAILED'), Message::get('DB_ERROR'));
            }
        } else {
            Session::add(Message::get('LOGIN_FAILED'), Message::get('DB_ERROR'));
        }
    }

    private static function resetLoginFail($username)
    {
        $db = Database::getDb()->connect();
        if ($query = $db->prepare("UPDATE
                    users
                SET
                  failed_login_count = 0,
                  last_failed_login = NULL
                WHERE
                  (username = ? OR email = ?) AND users.failed_login_count != 0 LIMIT 1")
        ) {
            $query->bind_param('ss', $username, $username);
            $query->execute();
            if ($query->errno) {
                Session::add(Message::get('LOGIN_FAILED'), Message::get('DB_ERROR'));
            }
        } else {
            Session::add(Message::get('LOGIN_FAILED'), Message::get('DB_ERROR'));
        }
    }

    private static function rememberMe($user_id)
    {
        $random_token = hash('sha256', openssl_random_pseudo_bytes(16));

        $db = Database::getDb()->connect();

        if ($query = $db->prepare("UPDATE
                users
            SET
              remember_me_token = ?
            WHERE
              id = ?
            LIMIT 1
        ")
        ) {
            $query->bind_param('ss', $random_token, $user_id);
            $query->execute();
            if ($query->errno) {
                Session::add(Message::get('LOGIN_FAILED'), Message::get('DB_ERROR'));
            }
        } else {
            Session::add(Message::get('LOGIN_FAILED'), Message::get('DB_ERROR'));
            return;
        }

        $cookie_string = $user_id . ':' . $random_token;
        $cookie_string = $cookie_string . ':' . hash('sha256', $cookie_string);
        setcookie('remember_me', $cookie_string, time() + Config::get('COOKIE_EXPIRE'), Config::get('COOKIE_PATH'));
    }

    private static function setSessionProperties($user_id, $username, $email)
    {
        Session::set('user_id', $user_id);
        Session::set('user_name', $username);
        Session::set('user_email', $email);
    }

    public static function checkUser($username)
    {
        if (UserModel::ifExists('username', strip_tags($username)) OR UserModel::ifExists('email', strip_tags($username)))
            return true;
        return false;
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