<?php

/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 31.08.2015
 * Time: 22:06
 */

require_once(Config::get('MODELS_PATH') . 'LoginModel.php');

class LoginController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // if user is logged in redirect to main-page, if not show the view
        if (LoginModel::isLoggedIn()) {
            Redirect::toPath('account');
        } else {
            $data = array('redirect' => Request::get_get('redirect') != NULL ? Request::get_get('redirect') : NULL);
            $this->View->render('login/login', $data);
        }
    }

    public function login()
    {
        // perform the login method, put result (true or false) into $login_successful
        $login_successful = LoginModel::login(
            Request::get_post('username'), Request::get_post('password'), Request::get_post('set_remember_me_cookie')
        );
        // check login status: if true, then redirect user login/showProfile, if false, then to login form again
        if ($login_successful) {
            if ($redirect = Request::get_post('redirect')) {
                Redirect::toPath(ltrim(urldecode($redirect), '/'));
            } else {
                Redirect::toPath('index');
            }
        } else {
            Redirect::toPath('login');
        }
    }

    public function logout(){
        LoginModel::logout();
        Redirect::toPath('login');
    }
}