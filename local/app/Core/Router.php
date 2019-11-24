<?php

namespace app\Core;

class Router {
    private $routes      = [];
    private $route_param = [];
    private $url;

    function __construct($routes, $url) {
        $page = $routes;
        $this->url= $url;
        foreach ($page as $key => $value) {
            $this->add($key, $value);
        }
    }

    public function add($route, $params) {
        $key                = '~^' . $route . '$~';
        $this->routes[$key] = $params;
    }

    public function getController() {
        $url = trim($this->url, '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                $this->route_param = $params;

                return $this->boot($this->route_param);
            }
        }
        return $this->error_controller(404);
    }

    public function boot($param, $action = '', $default = false) {
        $params = [];
        if($default ==! false && !is_array($param)){
            $params['controller'] =  $param;
            $params['action']     = $action;
        } else {
            $params = $param;
        }
        $path = 'app\Controller\\'.ucfirst($params['controller']).'Controller';
        if (class_exists($path)) {
            $action = $params['action'].'Action';
            if (method_exists($path, $action)) {
                $controller['controller'] = $path;
                $controller['action']     = $action;
                return $controller;
            } else {
                return  $this->error_controller(404);
            }
        } else {
            return $this->error_controller(403);
        }
    }

    public function error_controller (int $num = 404) {
        return $this->boot('Error', 'Error' . $num, true);
    }

}
