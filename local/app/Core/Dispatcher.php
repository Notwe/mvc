<?php

namespace app\Core;

//TODO Dispatcher должен возвращать результат работы Контроллера (Response)
class Dispatcher{
    private $path;
    private $url;
    private $container;
    private $response;

    function __construct($container){
        $this->container = $container;
        $this->response  = $container->get('Response');
        $this->url       = $container->get('Request')->getURL();
        $this->path      = $container->get('Router')->route_match($this->url);
        $container->set('path', $this->path);
        if(!empty ($this->path)){
            $this->loadController();
        }
    }


    public function loadController() {
        $path = 'app\Controller\\'.ucfirst($this->path['controller']).'Controller';
        if (class_exists($path)) {
            $action = $this->path['action'].'Action';
            if (method_exists($path, $action)) {
                $controller = new $path($this->container);
                $controller->$action();
            } else {
                return $this->response->errorPage();
            }
        } else {
            return $this->response->errorPage();
        }
    }
    public function display(){
       return $this->response->send();
    }
}
