<?php

/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 15.09.2015
 * Time: 23:18
 */
class FileModel
{
    public static function getFiles($user_id)
    {
        $db = Database::getDb()->connect();
        if ($query = $db->prepare("SELECT
                  file_path, file_name, date_created
                FROM
                  files
                WHERE
                  user_id = ? ORDER BY date_created DESC")
        ) {

            $query->bind_param('s', $user_id);
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

    public static function getBookmarks($user_id)
    {
        $db = Database::getDb()->connect();
        if ($query = $db->prepare("SELECT
                  file_id
                FROM
                  bookmarks
                WHERE
                  user_id = ? ORDER BY id DESC")
        ) {
            $query->bind_param('s', $user_id);
            $query->execute();
            $query->store_result();
            $query->bind_result($file_id);

            while ($query->fetch()) {

                if ($query = $db->prepare("SELECT
                  file_id
                FROM
                  bookmarks
                WHERE
                  user_id = ? ORDER BY id DESC")
                ) {

                }
            }

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

    public static function getFileIdByLink($link)
    {
        $db = Database::getDb()->connect();
        if ($query = $db->prepare("SELECT
                  file_id
                FROM
                  files
                WHERE
                  file_path = ? LIMIT 1")
        ) {

            $query->bind_param('s', $link);
            $query->execute();
            $query->store_result();
            $query->bind_result($file_id);
            $query->fetch();

            return $file_id;
        }
        return false;
    }

    public static function addBookmark($file_id)
    {
        $db = Database::getDb()->connect();
        if ($query = $db->prepare('
              INSERT INTO
                bookmarks
                (user_id, file_id)
              VALUES
                (?,?)')
        ) {
            $query->bind_param('ss', Session::get('user_id'), $file_id);
            if ($query->execute())
                return true;
        }

        return false;
    }

    public static function checkBookmark($file_id)
    {
        $db = Database::getDb()->connect();
        $stmt = 'SELECT user_id FROM bookmarks WHERE file_id = ? LIMIT 1';

        if ($query = $db->prepare($stmt)) {
            $query->bind_param('s', $file_id);
            $query->execute();
            $query->store_result();
            if ($query->num_rows == 0) {
                return true;
            }
        }
        return false;
    }

}