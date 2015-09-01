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
        ){

            $query->bind_param('ss',$username, $username);
            $query->execute();
            /*$query->store_result();
            $query->bind_result($user_id, $username, $password, $firstname, $lastname, $email, $failed_login_count, $last_failed_login, $active_user);
            return $query->fetch();*/

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
        return false;
    }
    function stmt_bind_assoc (&$stmt, &$out) {
        $data = mysqli_stmt_result_metadata($stmt);
        $fields = array();
        $out = array();

        $fields[0] = $stmt;
        $count = 1;

        while($field = mysqli_fetch_field($data)) {
            $fields[$count] = &$out[$field->name];
            $count++;
        }
        call_user_func_array(mysqli_stmt_bind_result, $fields);
    }

    private static function getAssocArrayFromSql(&$query, &$result){
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
}