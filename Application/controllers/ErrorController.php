<?php
/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 30.08.2015
 * Time: 17:09
 */

//namespace App;

class ErrorController extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function error404()
    {
        header('HTTP/1.0 404 Not Found', true, 404);
        $this->View->render('404');
    }
}