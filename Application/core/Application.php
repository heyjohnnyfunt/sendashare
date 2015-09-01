<?php

/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 30.08.2015
 * Time: 1:56
 */

//namespace App;

require_once('Config.php');
require_once('Auth.php');
require_once('Controller.php');
require_once('Database.php');
require_once('Message.php');
require_once('Redirect.php');
require_once('Request.php');
require_once('Session.php');
require_once('View.php');

/*function __autoload($class){
    require_once($class.'.php');
}*/

class Application
{
    private $controller;
    private $controller_name;
    private $action;
    private $params = array();

    function __construct()
    {
        $this->parse_url();
        $this->check_url();

        require_once(Config::get('CONTROLLERS_PATH') . $this->controller_name . '.php');

        $this->controller = new $this->controller_name();

        if (method_exists($this->controller, $this->action)) {
            if (!empty($this->params)) {
                call_user_func_array(array($this->controller, $this->action), $this->params);
            } else {
                // like $this->index->index();
                $this->controller->{$this->action}();
            }
        } else {
            // load 404 error page
            require Config::get('CONTROLLERS_PATH') . 'ErrorController.php';
            $this->controller = new ErrorController;
            $this->controller->error404();
        }

    }

    private function parse_url()
    {
        if(Request::get_get('url') == NULL){
            return;
        }
        $url = trim(Request::get_get('url'), '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);

        $this->controller_name = isset($url[0]) ? $url[0] : NULL;
        $this->action = isset($url[1]) ? $url[1] : NULL;

        unset($url[0], $url[1]);

        $this->params = array_values($url);
    }

    private function check_url()
    {
//        require_once(Config::get('MODELS_PATH') . ucwords($this->controller_name) . 'Model.php');
        $this->controller_name = ucwords($this->controller_name . 'Controller');
        if (!file_exists(Config::get('CONTROLLERS_PATH') . $this->controller_name . '.php')) {
            $this->controller_name = 'IndexController';
        }

        if ($this->action == NULL OR (strlen($this->action) == 0)) {
            $this->action = 'index';
        }

    }
}