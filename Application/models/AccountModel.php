<?php

/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 09.09.2015
 * Time: 20:59
 */
require_once 'UserModel.php';
require_once 'FileModel.php';

class AccountModel
{
    public static function getUserInfo()
    {
        if (!$userInfo = UserModel::getCurrentUser()) {
            return array('error_message' => Message::get('DB_ERROR'));
        }
        return $userInfo;
    }

    public static function checkUsername($username)
    {
        $username = strip_tags($username);
        if (empty($username) || strlen($username) < 2) return false;

        $db = Database::getDb()->connect();
        $stmt = 'SELECT id FROM users WHERE username = ? AND id != ? LIMIT 1';

        if ($query = $db->prepare($stmt)) {
            $query->bind_param('ss', $username, Session::get('user_id'));
            $query->execute();
            $query->store_result();
            if ($query->num_rows == 0) {
                return true;
            }
        }
        return false;
    }

    public static function updateUsername($username)
    {
        $username = strip_tags($username);
        if (empty($username) || strlen($username) < 2) return false;

        $db = Database::getDb()->connect();
        $stmt = "UPDATE users SET username = ? WHERE id = ? LIMIT 1";

        if ($query = $db->prepare($stmt)) {
            $query->bind_param('ss', $username, Session::get('user_id'));
            $query->execute();
            if ($query->errno) {
                Session::add(Message::get('LOGIN_FAILED'), Message::get('DB_ERROR'));
                return false;
            }
        } else {
            Session::add(Message::get('LOGIN_FAILED'), Message::get('DB_ERROR'));
            return false;
        }

        Session::set('user_name', $username);
        return true;
    }

    public static function checkEmail($email)
    {
        $email = strip_tags($email);
        if (empty($email) || strlen($email) < 8 || !filter_var($email, FILTER_VALIDATE_EMAIL)) return false;

        $db = Database::getDb()->connect();
        $stmt = 'SELECT id FROM users WHERE email = ? AND id != ? LIMIT 1';

        if ($query = $db->prepare($stmt)) {
            $query->bind_param('ss', $email, Session::get('user_id'));
            $query->execute();
            $query->store_result();
            if ($query->num_rows == 0) {
                return true;
            }
        }
        return false;
    }

    public static function updateEmail($email)
    {
        $email = strip_tags($email);
        if (empty($email) || strlen($email) < 8 || !filter_var($email, FILTER_VALIDATE_EMAIL)) return false;

        $db = Database::getDb()->connect();
        $stmt = "UPDATE users SET email = ? WHERE id = ? LIMIT 1 ";

        if ($query = $db->prepare($stmt)) {
            $query->bind_param('ss', $email, Session::get('user_id'));
            $query->execute();
            if ($query->errno) {
                Session::add(Message::get('LOGIN_FAILED'), Message::get('DB_ERROR'));
                return false;
            }
        } else {
            Session::add(Message::get('LOGIN_FAILED'), Message::get('DB_ERROR'));
            return false;
        }

        Session::set('user_email', $email);
        return true;
    }

    public static function updateName($name_type, $name)
    {
        $name = strip_tags($name);
        $db = Database::getDb()->connect();
        switch ($name_type) {
            case 'firstname':
                $stmt = "UPDATE users SET firstname = ? WHERE id = ? LIMIT 1";
                break;
            case 'lastname':
                $stmt = "UPDATE users SET lastname = ? WHERE id = ? LIMIT 1";
                break;
            default:
                $stmt = "UPDATE users SET firstname = ? WHERE id = ? LIMIT 1";
                break;
        }

        if ($query = $db->prepare($stmt)) {
            $query->bind_param('ss', $name, Session::get('user_id'));
            $query->execute();
            if ($query->errno) {
                Session::add(Message::get('LOGIN_FAILED'), Message::get('DB_ERROR'));
                return false;
            }
        } else {
            Session::add(Message::get('LOGIN_FAILED'), Message::get('DB_ERROR'));
            return false;
        }

        return true;
    }

    public static function updatePassword($password)
    {
        $password = strip_tags($password);
        if (empty($password) || strlen($password) < 6) return false;

        $password = password_hash($password, PASSWORD_DEFAULT);
        $db = Database::getDb()->connect();
        $stmt = "UPDATE users SET password = ? WHERE id = ? LIMIT 1 ";

        if ($query = $db->prepare($stmt)) {
            $query->bind_param('ss', $password, Session::get('user_id'));
            $query->execute();
            if ($query->errno) {
                Session::add(Message::get('LOGIN_FAILED'), Message::get('DB_ERROR'));
                return false;
            }
        } else {
            Session::add(Message::get('LOGIN_FAILED'), Message::get('DB_ERROR'));
            return false;
        }

        Session::set('user_email', $password);
        return true;
    }

    public static function addUserFile($filePath, $fileName)
    {
        $db = Database::getDb()->connect();
        if ($query = $db->prepare('
              INSERT INTO
                files
                (user_id, file_path, file_name, date_created)
              VALUES
                (?,?,?,?)')
        ) {
            $query->bind_param('ssss', Session::get('user_id'), $filePath, $fileName, date('Y-m-d H:i:s'));
            if ($query->execute())
                return true;
        }

        return false;
    }

    public static function getUserFiles()
    {
        if (!$fileInfo = FileModel::getUserFiles()) {
            return array('error_message' => Message::get('DB_ERROR'));
        }
        return $fileInfo;
    }
}