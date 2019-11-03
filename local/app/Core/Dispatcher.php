<?php

namespace app\Core;

class Dispatcher{

    private $controller;
    private $action;
    private $path;
    private $url;
    private $request;
    private $container;

    function __construct($container){
        $this->container = $container;
        $this->request = $container->get('Request');
        $this->url = $this->request->getURL();
        $this->path = $container->get('Router')->route_match($this->url);
        if($this->path){
            $this->loadController();
        }
    }


    public function loadController(){
            $path = 'app\Controller\\'.ucfirst($this->path['controller']).'Controller';
            if(class_exists($path)){
                $action = $this->path['action'].'Action';
                if(method_exists($path, $action)){
                    $controller = new $path($this->path, $this->request, $this->container);
                    $controller->$action();
                }else{

                    //View::errorPage('404');
                }
            }else{
                //View::errorPage('404');
            }
    }

}
