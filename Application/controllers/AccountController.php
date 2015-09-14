<?php
/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 30.08.2015
 * Time: 15:12
 */

//namespace App;

require_once(Config::get('MODELS_PATH') . 'LoginModel.php');
require_once(Config::get('MODELS_PATH') . 'AccountModel.php');

class AccountController extends Controller
{
    public function __construct(){
        parent::__construct();
        Auth::checkAuth();
    }

    public function index(){

        $this->View->render('account/index');
    }

    public function settings(){
        $data = AccountModel::getPublicInfo();
        $this->View->render('account/settings', $data);
    }

    public function saveUsername()
    {
        if (!AccountModel::checkUsername(Request::get_post('username'))) {
            echo 'USER_EXISTS';
            return;
        }

        if (!AccountModel::updateUsername(Request::get_post('username'))){
            echo 'NOT_UPDATED';
            return;
        }
        echo 'Y';
    }

    public function saveEmail()
    {
        if (!AccountModel::checkEmail(Request::get_post('email'))) {
            echo 'EMAIL_EXISTS';
            return;
        }

        if (!AccountModel::updateEmail(Request::get_post('email'))){
            echo 'NOT_UPDATED';
            return;
        }
        echo 'Y';
    }
    public function saveFirstName()
    {
        if (!AccountModel::updateName('firstname', Request::get_post('firstname'))){
            echo 'NOT_UPDATED';
            return;
        }
        echo 'Y';
    }
    public function saveLastName()
    {
        if (!AccountModel::updateName('lastname', Request::get_post('lastname'))){
            echo 'NOT_UPDATED';
            return;
        }
        echo 'Y';
    }
    public function changePassword()
    {
        if (!AccountModel::updatePassword(Request::get_post('password'))){
            echo 'NOT_UPDATED';
            return;
        }
        echo 'Y';
    }

    public function ajaxUpload()
    {
        $uploaddir = getcwd().DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR;
        $uploadfile = $uploaddir.basename($_FILES['file']['name']);

        move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
    }
}