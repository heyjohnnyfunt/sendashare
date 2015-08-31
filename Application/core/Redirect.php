<?php

/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 31.08.2015
 * Time: 21:54
 */
class Redirect
{
    public static function home(){
        header("Location: " . Config::get('URL'));
    }

    public static function toPath($path){
        header("Location: " . Config::get('URL') . '/' . $path);
    }
}