<?php

namespace app\Controller;
use app\Model\View;


abstract class AbstractController{
    public $path;
    public $view;
    public $model;
    public $page_params = [];
    public $user_data = [];
    public $container;
    public $response;
    public $page_title;

    function __construct($container) {
        $this->container  = $container;
        $this->path       = $container->get('path');
        $this->response   = $container->get('Response');
        $this->view       = $container->get('View');
        $this->page_title = $container->get('Title')->get($this->path['action']);
    }

    public function getModel(string $name){
        $path = $this->container->get('Model')->$name;
        if(class_exists($path)){
            return new $path($this->container);
        }
    }

}
