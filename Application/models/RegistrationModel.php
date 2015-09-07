<?php

/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 05.09.2015
 * Time: 15:13
 */
class RegistrationModel
{
    public static function register()
    {
        $fields = self::get_fields();

        if (!self::validation($fields)) {
            return false;
        }

        if(!UserModel::addUser($fields)){
            return false;
        }

        return true;
    }

    private static function get_fields()
    {
        $username = strip_tags(Request::get_post('username'));
        $email = strip_tags(Request::get_post('email'));
        $firstname = strip_tags(Request::get_post('firstname'));
        $lastname = strip_tags(Request::get_post('lastname'));
        $password = strip_tags(Request::get_post('password'));
        $conf_password = strip_tags(Request::get_post('confPassword'));

        return array(
            'username' => $username,
            'email' => $email,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'password' => $password,
            'conf_password' => $conf_password
        );

    }

    private static function validation($field_array)
    {
        extract($field_array);
        if (!(self::validateUsername($username)
            AND self::validateEmail($email)
            AND self::validateName($firstname)
            AND self::validateName($lastname)
            AND self::validatePassword($password, $conf_password))
        ){
            return false;
        }

        if (UserModel::ifExists('username', $username) OR UserModel::ifExists('email', $email)){
            return false;
        }

        return true;
    }

    private static function validateUsername($username)
    {
        if (empty($username)) {
            Session::add(Message::get('LOGIN_FAILED'), Message::get('EMPTY_USERNAME'));
            return false;
        }
        if (!preg_match('/^[a-zA-Z0-9]{2,32}$/', $username)) {
            Session::add(Message::get('LOGIN_FAILED'), Message::get('USERNAME_ERROR'));
            return false;
        }
        return true;
    }

    private static function validateEmail($email)
    {
        if (empty($email)) {
            Session::add(Message::get('LOGIN_FAILED'), Message::get('EMPTY_EMAIL'));
            return false;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::add(Message::get('LOGIN_FAILED'), Message::get('EMAIL_ERROR'));
            return false;
        }
        return true;
    }


    private static function validateName($name)
    {
        if(empty($name)) return true;

        if (!preg_match('/^[a-zA-Z]{2,64}$/', $name)) {
            Session::add(Message::get('LOGIN_FAILED'), Message::get('NAME_ERROR'));
            return false;
        }
        return true;
    }

    private static function validatePassword($password, $conf_password)
    {
        if (empty($password) OR empty($conf_password)) {
            Session::add(Message::get('LOGIN_FAILED'), Message::get('EMPTY_PASSWORD'));
            return false;
        }
        if ($password !== $conf_password) {
            Session::add(Message::get('LOGIN_FAILED'), Message::get('PASSWORD_NOT_MATCH'));
            return false;
        }
        if (strlen($password) < 6) {
            Session::add(Message::get('LOGIN_FAILED'), Message::get('PASSWORD_ERROR'));
            return false;
        }
        return true;
    }

    // for ajax
    public static function checkUserName($username){
        if (UserModel::ifExists('username', strip_tags($username)))
            return true;
        return false;
    }
    public static function checkUserEmail($email){
        if (UserModel::ifExists('email', strip_tags($email)))
            return true;
        return false;
    }

}