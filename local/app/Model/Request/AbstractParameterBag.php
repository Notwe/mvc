<?php


namespace app\Model\Request;


abstract class AbstractParameterBag {
    protected $parameters;

    public function __construct(array $parameters) {
        $this->parameters = $parameters;
    }

    public function get(string $name, $defult = false) {
        if ($defult === true) {
            return $_POST;
        }
        if(array_key_exists($name, $this->params)) {
            return $this->parameters[$name];
        }

        return false;
    }

    public function add(array $parameters = []) {
        $this->parameters = array_replace($this->parameters, $parameters);
    }

    public function set($key, $value) {
        $this->parameters[$key] = $value;
    }

}