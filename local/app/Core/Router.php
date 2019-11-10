<?php

namespace app\Core;

class Router {
    private $routes      = [];
    private $route_param = [];

    function __construct($routes) {
        $page = $routes;
        foreach ($page as $key => $value) {
            $this->add($key, $value);
        }
    }

    public function add($route, $params) {
        $key                = '~^' . $route . '$~';
        $this->routes[$key] = $params;
    }

    public function route_match($url) {
        $url = trim($url, '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                $this->route_param = $params;

                return $this->route_param;
            }
        }

        return false;
    }

}
