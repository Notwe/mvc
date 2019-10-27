<?php

namespace app\Config\Core;

class Dispatcher{

    private $controller;
    private $action;
    private $path;
    private $url;
    private $request;

    function __construct(){
        $this->request = new Request;
        //debug($this->request);
        $this->url = $this->request->getURL();
        $this->path = (new Router())->route_match($this->url);
        $this->loadController();
    }


    public function loadController(){
            $path = 'app\Controller\lib\\'.ucfirst($this->path['controller']).'Controller';
            if(class_exists($path)){
                $action = $this->path['action'].'Action';
                if(method_exists($path, $action)){
                    $controller = new $path($this->path, $this->request);
                    $controller->$action();
                }else{

                    //View::errorPage('404');
                }
            }else{
                //View::errorPage('404');
            }
    }

}
