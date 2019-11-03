<?php

namespace app\Controller;
use app\View\View;
use app\View\Config\PageParams;

//TODO модель в классе может быть не одна. Не нужно ее динамически подключать (ее нужно передавать аргументом
// класса
abstract class AbstractController{
    public $route_path;
    public $view;
    public $model;
    public $page_params;
    public $user_data = [];
    public $request;
    public $container;

    function __construct($route, $Request, $container){
        $this->container = $container;
        $this->request = $Request;
        $this->route_path = $route;
        //load models
        $this->model = $this->model($route['controller']);
        //load views
        $this->view = new View($route);
        //params PageJ
        $this->page_params = new PageParams;

    }

    public function model($name){
        $path = 'app\Model\\'.ucfirst($name).'Model';
        if(class_exists($path)){
            return new $path($this->container->get('Database'));
        }
    }

    //TODO логику вынести в модель. Поправить орфографические ошибки
    public function check_user_coockie(){
        $login = trim($this->request->CookieGet('login'));
        $password = trim($this->request->CookieGet('pass'));
        if(!empty($login) && !empty($password)){
            if($this->model->find_user($login, $password) === true){
                $this->user_data = $this->model->get_user_data($login, $password);
                $this->page_params->user_data = $this->user_data;
                return true;
                }
            }
        $this->request->CookieSet('login', '', time() -100500);
        $this->request->CookieSet('pass', '', time() -100500);
        return false;
    }

}
