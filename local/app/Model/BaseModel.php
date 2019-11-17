<?php


namespace app\Model;
/**
 * @property string Main
 * @property string Index
 * @property string Account
 * @property string Register
 * @property string Authorise
 */



class BaseModel{
    private $container;
    public function __construct ($container) {
        $this->container = $container;
    }

    public function __get(string $name) {
        $path = 'app\Model\\'.ucfirst($name) . 'Model';
        if(class_exists($path)){
            return new $path($this->container);
        }
        throw new \Exception('No found Model with the name "' . $name . '"');


    }
}