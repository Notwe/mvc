<?php

namespace app\Model\Container;

class ServiceContainer
{
    protected $services = [];

    protected $resolved_services = [];

    public function  __construct ($params){
        $this->service_init($params);
    }

    public function get(string $name) {
        if (array_key_exists($name, $this->resolved_services)) {
            return $this->resolved_services[$name];
        }

        if (!array_key_exists($name, $this->services)) {
            throw new \Exception('Service with key "' . $name . '" does not exist!');
        }
        if (is_object($this->services[$name]) && $this->services[$name] instanceof \Closure) {

            $this->resolved_services[$name] = $this->services[$name]($this);
         } else {
            $this->resolved_services[$name] = $this->services[$name];
        }

        return $this->resolved_services[$name];
    }

    public function set(string $name, $service) {
        $this->services[$name] = $service;
    }

    public function service_init(array $services) {
        foreach ($services as $path_service) {
            $this->services = array_merge($this->services, require $path_service);
        }
    }
}
