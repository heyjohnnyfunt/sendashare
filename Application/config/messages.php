<?php
/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 30.08.2015
 * Time: 12:27
 */

return array(
    // name of session keys
    'LOGIN_FAILED' => 'login_failed_feedback',

    // base errors
    'BASE_ERROR' => 'Something bad',
    'ERROR404' => 'Sorry, page not found :(',
    'DB_ERROR' => 'Ошибка подключения к базе данных..',

    // login errors
    'NO_USER' => 'Пользователь не найден. Попробуйте войти еще раз',
    'LOGIN_3_ATTEMPTS' => 'Вы неудачно зашли 3 раза подряд. Подождите 30 секунд',
    'ACCOUNT_NOT_ACTIVATED' => 'Аккаунт неактивирован',
    'WRONG_PASSWORD' => 'Неверный пароль',

    // registration errors
    'REGISTRATION_ERROR' => 'Ошибка регистрации. Проверьте вводимые данные',
    'EMPTY_USERNAME' => 'Введите имя пользователя',
    'EMPTY_EMAIL' => 'Введите email',
    'EMPTY_PASSWORD' => 'Введите пароль',
    'EMPTY_CONF_PASSWORD' => 'Повторите пароль',
    'PASSWORD_NOT_MATCH' => 'Введите одинаковые пароли',
    'USERNAME_ERROR' => 'Имя пользователя должно быть от 2 до 32 символов и содержать только цифры и буквы латинского алфавита',
    'NAME_ERROR' => 'Имя и фамилия должны быть от 2 до 64 символов и содержать только буквы латинского алфавита',
    'PASSWORD_ERROR' => 'Пароль должен содержать минимум 6 символов'
);