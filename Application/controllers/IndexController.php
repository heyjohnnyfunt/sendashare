<?php
/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 30.08.2015
 * Time: 17:52
 */

//namespace App;

require_once(Config::get('CORE_PATH') . 'Controller.php');
require_once(Config::get('MODELS_PATH') . 'LoginModel.php');

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        Auth::checkAuth();
    }

    public function index()
    {
        if (LoginModel::isLoggedIn()) {
            Redirect::toPath('account');
        } else {
            $this->View->render('index');
        }
    }
}