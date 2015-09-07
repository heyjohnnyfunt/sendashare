<?php

/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 31.08.2015
 * Time: 22:06
 */

require_once(Config::get('MODELS_PATH') . 'LoginModel.php');
require_once(Config::get('MODELS_PATH') . 'RegistrationModel.php');

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
        $login_successful = LoginModel::login(
            Request::get_post('username'), Request::get_post('password'), Request::get_post('remember_me')
        );

        if ($login_successful) {
            if ($redirect = Request::get_post('redirect')) {
                Redirect::toPath(ltrim(urldecode($redirect), '/'));
            } else {
                Redirect::toPath('account');
            }
        } else {
            Redirect::toPath('login');
        }
    }

    public function registration()
    {
        if (LoginModel::isLoggedIn()) {
            Redirect::toPath('account');
        } else {
            $data = array('redirect' => Request::get_get('redirect') != NULL ? Request::get_get('redirect') : NULL);
            $this->View->render('login/register', $data);
        }
    }

    public function register()
    {
        if (RegistrationModel::register()) {
            if ($redirect = Request::get_post('redirect')) {
                Redirect::toPath(ltrim(urldecode($redirect), '/'));
            } else {
                Redirect::toPath('login');
            }
        } else {
            Redirect::toPath('login/registration');
        }
    }

    public function checkUsernameLogin()
    {
        if (!LoginModel::checkUser(Request::get_post('username'))) {
            echo 'N';
        } else echo 'Y';
    }

    public function checkUsernameReg()
    {
        if (RegistrationModel::checkUserName(Request::get_post('username'))) {
            echo 'N';
        } else echo 'Y';
    }

    public function checkUserEmailReg()
    {
        if (RegistrationModel::checkUserEmail(Request::get_post('email'))) {
            echo 'N';
        } else echo 'Y';
    }

    public function logout()
    {
        LoginModel::logout();
        Redirect::home();
    }
}