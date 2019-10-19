<?php

namespace app\Controller;
use app\View\View;
use app\View\lib\PageParams;
abstract class AbstractController{
    public $route_path;
    public $view;
    public $model;
    public $page_params;
    public $user_data = [];

    function __construct($route){
        $this->route_path = $route;
        //load models
        $this->model = $this->model($route['controller']);
        //load views
        $this->view = new View($route);
        //params PageJ
        $this->page_params = new PageParams;

    }

    public function model($name){
        $path = 'app\Model\lib\\'.ucfirst($name).'Model';
        if(class_exists($path)){
            return new $path;
        }
    }

    public function check_user_coockie(){
        if(!empty($_COOKIE['login']) && !empty($_COOKIE['pass'])){
            if($this->model->find_user(trim($_COOKIE['login']), trim($_COOKIE['pass'])) === true){
                $this->user_data = $this->model->get_user_data($_COOKIE['login'], $_COOKIE['pass']);
                $this->page_params->user_data = $this->user_data;
                return true;
                }
            }else{
                setcookie('login', "", time() -100500, '/');
                setcookie('pass', "", time() -100500, '/');
                return false;
        }

    }

}
