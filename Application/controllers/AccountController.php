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
        $data = AccountModel::getUserFiles();
        $this->View->render('account/files', $data);
    }

    public function files()
    {
        $data = AccountModel::getUserFiles();
        $this->View->render('account/files', $data);
    }

    public function settings()
    {
        $data = AccountModel::getUserInfo();
        $this->View->render('account/settings', $data);
    }

    public function upload()
    {
        $this->View->render('account/upload');
    }

    public function bookmarks()
    {
        $data = AccountModel::getUserBookmarks();
        $this->View->render('account/bookmarks', $data);
    }

    public function addBookmark()
    {
        if (!AccountModel::addUserBookmark(Request::get_post('link'))) {
            echo 'N';
        } else {
            echo 'Y';
        }
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
        $user_dir = "uploads/" . Session::get('user_id') . '/';
        $local_dir = BASE_PATH . $user_dir;
        if (!file_exists($local_dir)) {
            mkdir($local_dir, 0777, true);
        }

        $fileBasename = basename($_FILES['fileToUpload']['name']);
        $ext = explode('.', $fileBasename);
        var_dump($ext);
        $file_name = md5(uniqid()) . "." . $ext[count($ext) - 1];
        $local_path = $local_dir . $file_name;
        $public_path = Config::get('URL') . '/' . $user_dir . $file_name;

        if ($_FILES["fileToUpload"]["size"] > 100 * 1024 * 1024) {
            echo "Sorry, file " . $fileBasename . " is too large.";
            return;
        }

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $local_path)) {
            if (AccountModel::addUserFile($public_path, $fileBasename))
                echo $fileBasename;// . " has been uploaded successfully.\n";
            else
                echo "N";
        } else {
            echo 'N';
//            echo "There was an error uploading " . $fileBasename . ", please try again..";
        }

    }

    public static function checkPage($page)
    {
        if (Request::get_get('url') == NULL) {
            return false;
        }
        $url = trim(Request::get_get('url'), '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);
        return ($url[1] === $page) ? true : false;
    }
}