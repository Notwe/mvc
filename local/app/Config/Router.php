<?php
namespace app\Config;
use app\Config\lib\Routing;
use app\View\View;
//

class Router{
    private $routes = [];
    private $route_param = [];
    function __construct(){
        $page = new Routing;
        $page = $page->getPage();
        //var_dump($page);
        foreach ($page as $key => $value) {
            $this->add($key, $value);
        }
    }
    private function getURL(){
        if(!empty($_SERVER['REQUEST_URI'])){
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function add($route, $params){
        $key = '~^'.$route.'$~';
        $this->routes[$key] = $params;
    }

    public function route_match(){
        $url = $this->getURL();
        foreach ($this->routes as $route => $params) {
            if(preg_match($route, $url, $matches)){
                $this->route_param = $params;
                return true;
            }
        }
        return false;
    }

    public function start(){
         if($this->route_match()){
             $path = 'app\Controller\lib\\'.ucfirst($this->route_param['controller']).'Controller';;
             if(class_exists($path)){
                 $action = $this->route_param['action'].'Action';
                 if(method_exists($path, $action)){
                     $controller = new $path($this->route_param);
                     $controller->$action();
                 }else{
                     View::errorPage('404');
                 }
             }else{
                 View::errorPage('404');
             }
         }else{
             View::errorPage('404');
         }
     }
}
