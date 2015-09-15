<?php

/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 29.08.2015
 * Time: 21:19
 */

//namespace App;

class View
{
    public function render($filename, $data = null)
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }
        require Config::get('VIEWS_PATH') . 'templates/header.php';
        require Config::get('VIEWS_PATH') . $filename . '.php';
        require Config::get('VIEWS_PATH') . 'templates/footer.php';
    }
}