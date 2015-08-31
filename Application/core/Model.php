<?php
/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 29.08.2015
 * Time: 21:19
 */


class Model
{
    public static function isLoggedIn(){
        return Session::userIsLoggedIn();
    }
}