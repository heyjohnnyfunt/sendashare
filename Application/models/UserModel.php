<?php

/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 31.08.2015
 * Time: 22:55
 */
class UserModel
{
    public static function checkUser($username)
    {
        $db = Database::getDb()->connect();
        if ($query = $db->prepare("SELECT
                  id,
                  username,
                  password,
                  firstname,
                  lastname,
                  email,
                  failed_login_count,
                  last_failed_login,
                  active_user
                FROM
                  users
                WHERE
                  (username = ? OR email = ?) LIMIT 1")
        ) {

            $query->bind_param('ss', $username, $username);
            $query->execute();
            /*$query->store_result();
            $query->bind_result($user_id, $username, $password, $firstname, $lastname, $email, $failed_login_count, $last_failed_login, $active_user);
            return $query->fetch();*/
            return self::getAssocArrayFromSql($query);

        }
        return false;
    }

    private static function getAssocArrayFromSql(&$query)
    {
        $params = array();
        $result = array();
        $meta = $query->result_metadata();

        while ($field = $meta->fetch_field()) {
            $params[] = &$result[$field->name];
        }

        call_user_func_array(array($query, 'bind_result'), $params);
        if ($query->error) return false;

        while ($query->fetch()) {
            foreach ($result as $key => $val)
                $c[$key] = $val;
            $params = $c;
        }
        return $params;
    }

    public static function ifExists($sql_field, $value)
    {
        $db = Database::getDb()->connect();
        switch ($sql_field) {
            case 'username':
                $stmt = 'SELECT id FROM users WHERE username = ? LIMIT 1';
                break;
            case 'email':
                $stmt = 'SELECT id FROM users WHERE email = ? LIMIT 1';
                break;
            default:
                $stmt = 'SELECT id FROM users WHERE username = ? LIMIT 1';
                break;
        }

        if ($query = $db->prepare($stmt)) {
            $query->bind_param('s', $value);
            $query->execute();
            $query->store_result();
//            return self::getAssocArrayFromSql($query);
            if ($query->num_rows == 0){
                return false;
            }
        }
        return true;
    }


    public static function addUser($fields)
    {
        extract($fields);

//        if(empty($firstname)) $firstname = 'NULL';
//        if(empty($lastname)) $lastname = 'NULL';

        $password = password_hash($password, PASSWORD_DEFAULT);

        $db = Database::getDb()->connect();

        if ($query = $db->prepare('
              INSERT INTO
                users
                (username, password, firstname, lastname, email)
              VALUES
                (?,?,?,?,?)')
        ) {
            $query->bind_param('sssss', $username, $password, $firstname , $lastname, $email);
            if ($query->execute())
                return true;
        }

        return false;
    }


}