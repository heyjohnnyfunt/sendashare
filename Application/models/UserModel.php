<?php

/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 31.08.2015
 * Time: 22:55
 */
class UserModel
{
    public static function checkUser($username, $password)
    {
        $db = Database::getDb()->connect();
        if($query = $db->prepare("SELECT
                  id,
                  firstname,
                  lastname,
                  email
                FROM
                  users
                WHERE
                  username = ? LIMIT 1")
        ){
            $query->bind_param('s',$username);
            $query->execute();
            $query->store_result();
            $query->bind_result($user_id, $firstname, $lastname, $email);
            $query->fetch();

            return array($user_id, $firstname, $lastname, $email);

        }
        return false;
    }
}