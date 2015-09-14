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
    public function __construct()
    {
        parent::__construct();
        Auth::checkAuth();
    }

    public function index()
    {

        $this->View->render('account/index');
    }

    public function settings()
    {
        $data = AccountModel::getPublicInfo();
        $this->View->render('account/settings', $data);
    }

    public function saveUsername()
    {
        if (!AccountModel::checkUsername(Request::get_post('username'))) {
            echo 'USER_EXISTS';
            return;
        }

        if (!AccountModel::updateUsername(Request::get_post('username'))) {
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

        if (!AccountModel::updateEmail(Request::get_post('email'))) {
            echo 'NOT_UPDATED';
            return;
        }
        echo 'Y';
    }

    public function saveFirstName()
    {
        if (!AccountModel::updateName('firstname', Request::get_post('firstname'))) {
            echo 'NOT_UPDATED';
            return;
        }
        echo 'Y';
    }

    public function saveLastName()
    {
        if (!AccountModel::updateName('lastname', Request::get_post('lastname'))) {
            echo 'NOT_UPDATED';
            return;
        }
        echo 'Y';
    }

    public function changePassword()
    {
        if (!AccountModel::updatePassword(Request::get_post('password'))) {
            echo 'NOT_UPDATED';
            return;
        }
        echo 'Y';
    }

    public function ajaxUpload()
    {
//        var_dump(($_FILES["fileToUpload"]));
        $target_dir = BASE_PATH . "uploads/" . Session::get('user_id') . '/';
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $fileBasename = basename($_FILES['fileToUpload']['name']);
        $ext = explode('.', $fileBasename);
        $target_path = $target_dir . md5(uniqid()) . "." . $ext[count($ext) - 1];

        if ($_FILES["fileToUpload"]["size"] > 100 * 1024 * 1024) {
            echo "Sorry, file " . $fileBasename . " is too large.";
            return;
        }

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_path)) {
            echo $fileBasename . " has been uploaded successfully.\n";
        } else {
            echo "There was an error uploading " . $fileBasename . ", please try again..";
        }

    }
}