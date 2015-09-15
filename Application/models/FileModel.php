<?php

/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 15.09.2015
 * Time: 23:18
 */
class FileModel
{
    public static function getUserFiles()
    {
        $db = Database::getDb()->connect();
        if ($query = $db->prepare("SELECT
                  file_path, file_name, date_created
                FROM
                  files
                WHERE
                  user_id = ? ORDER BY date_created DESC")
        ) {

            $query->bind_param('s', Session::get('user_id'));
            $query->execute();
            $query->store_result();
            $query->bind_result($file_path, $file_name, $date_created);

            $rows = self::stmt_bind_assoc($query);

            while ($query->fetch()) {
                foreach ($rows as $key => $value) {
                    $row_tmb[$key] = $value;
                }
                $files[] = $row_tmb;
            }
            $file_arr['files'] = $files;
            return $file_arr;
        }
        return false;
    }

    private static function stmt_bind_assoc(&$stmt)
    {
        $data = $stmt->result_metadata();
        $fields = array();
        $out = array();

        while ($field = $data->fetch_field()) {
            $fields[] = &$out[$field->name];
        }
        call_user_func_array(array($stmt, 'bind_result'), $fields);
        return $out;
    }

}