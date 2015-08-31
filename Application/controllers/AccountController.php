<?php
/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 30.08.2015
 * Time: 15:12
 */

//namespace App;
//use App\Controller;

include(dirname(realpath(__DIR__)) . '/core/Controller.php');

class AccountController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->View->render('index');
    }
}