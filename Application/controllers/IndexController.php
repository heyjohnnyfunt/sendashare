<?php
/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 30.08.2015
 * Time: 17:52
 */

//namespace App;

include(dirname(realpath(__DIR__)) . '/core/Controller.php');

class IndexController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->View->render('index');
    }
}