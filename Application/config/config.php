<?php
/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 29.08.2015
 * Time: 0:40
 */

//namespace App;

DEFINE('APP_PATH', dirname(realpath(__DIR__)) . '/');
DEFINE('BASE_PATH', dirname(dirname(realpath(__DIR__))) . '/');

return array(
    'URL' => '//' . $_SERVER['HTTP_HOST'],
    'COOKIE_EXPIRE' => 60*60*24*30, //30 days
    'COOKIE_PATH' => '/',

    'DB_NAME' => 'sendashare',
    'DB_HOST' => 'localhost',
    'DB_USER' => 'mysql',
    'DB_PASS' => 'mysql',

    'APP_PATH' => APP_PATH,
    'CONFIG_PATH' => APP_PATH . 'config/',
    'VIEWS_PATH' => APP_PATH . 'views/',
    'MODELS_PATH' => APP_PATH . 'models/',
    'CONTROLLERS_PATH' => APP_PATH . 'controllers/',
    'CSS_PATH' => BASE_PATH . 'css/',
    'JS_PATH' => BASE_PATH . 'js/'

);