<?php
/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 29.08.2015
 * Time: 21:19
 */

//namespace App;


class Controller
{
    protected $View;

    protected function __construct()
    {
        // always initialize a session
        Session::init();

        // user is not logged in but has remember-me-cookie ? then try to login with cookie ("remember me" feature)
        if (!Session::userIsLoggedIn() AND Request::get_cookie('remember_me') !== NULL) {
//            header('location: ' . Config::get('URL') . 'login');
            echo '<p>User is not logged in</p>';
        }
        // create a view object to be able to use it inside a controller, like $this->View->render();
        $this->View = new View();
    }
}