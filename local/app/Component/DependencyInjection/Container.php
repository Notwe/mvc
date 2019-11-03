<?php

namespace app\Component\DependencyInjection;

use app\Component\DependencyInjection\DefaultComponet;

//TODO переписать полностью. Reflection не нужен
class Container extends DefaultComponet{

    private $container;
    private $default_component;

    //TODO базовый набор параметров должен передоватся через конструктор (замыкания!!!!!!!!!)
    public function __construct(){
        $this->container = new \stdClass();
        $this->default_component = $this->getDefaultComponent();
    }
    public function get($class_name, $method = '__construct', $default = false){
        $class_name = $this->findDefaultComponent($class_name);

        if (isset($this->container->{$class_name})) {
            return $this->container->{$class_name};
        }

        if (!class_exists($class_name)){
            throw new \Exception("Class $className not found!");
        }

        if (method_exists($class_name, $method) !== false) {
            $ref_Method = new \ReflectionMethod($class_name, $method);
            $params = $ref_Method->getParameters();
            $args = [];

            foreach ($params as $key => $param) {
                if ($param->isDefaultValueAvailable()) {
                    $args[$param->name] = $param->getDefaultValue();
                } else {
                    if(is_object($param)){
                        // $name = $this->findDefaultComponent(ucfirst($param->name));
                        // if($name != $param->name){
                        //     $args[$param->name] = $this->get($name);
                        // }else{
                            $class = $param->getClass();
                            if ($class !== null) {
                                $args[$param->name] = $this->get($class->name);
                            }
                        //}
                    } else {
                        throw new \Exception("Not found {$class->name} in container");
                    }
                }
            }

            $ref_Class = new \ReflectionClass($class_name);
            if($default !== false){
                $class_instance = $ref_Method->invokeArgs(new $class_name(), (array)$args);
            }else{
                $class_instance = $ref_Class->newInstanceArgs((array)$args);
            }
        } else {
            $class_instance = new $class_name();
        }
        return $this->container->{$class_name} = $class_instance;

    }

    private function findDefaultComponent($class_name){
        foreach ($this->default_component as $key => $value) {
            if($key == $class_name){
                $class_name = $value;
                return $class_name;
            }
        }
        return $class_name;
    }
}
