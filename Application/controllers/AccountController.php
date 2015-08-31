<?php
/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 30.08.2015
 * Time: 15:12
 */

//namespace App;

class AccountController extends Controller
{
    public function __construct(){
        parent::__construct();
        Auth::checkAuth();
    }

    public function index(){
        $this->View->render('index');
    }
}