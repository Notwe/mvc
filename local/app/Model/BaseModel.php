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
    public function __get(string $name) {
        $path = 'app\Model\\'.ucfirst($name) . 'Model';
        if(class_exists($path)){
            return $path;
        }
        throw new \Exception('No found Model with the name "' . $name . '"');


    }
}