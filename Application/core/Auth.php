<?php

/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 31.08.2015
 * Time: 21:50
 */
class Auth
{
    public static function checkAuth()
    {
        Session::init();
        if (!Session::userIsLoggedIn()) {
            Session::destroy();
            header('location: ' . Config::get('URL') . '/login?redirect=' . urlencode($_SERVER['REQUEST_URI']));
            // to prevent fetching views via cURL (which "ignores" the header-redirect above) I leave the application
            // the hard way, via exit(). @see https://github.com/panique/php-login/issues/453
            // this is not optimal and will be fixed in future releases
            exit();
        }
    }
}