<?php


namespace app\Component;


class Request{

    function __construct(){
        //debug($this->methodPost('login'));
    }

    public function getURL(){
        if(!empty($_SERVER['REQUEST_URI'])){
            return $_SERVER['REQUEST_URI'];
        }
    }


    public function getMethod(){

        if (isset($_SERVER['REQUEST_METHOD'])) {
            return strtoupper($_SERVER['REQUEST_METHOD']);
        }
    }

    public function methodGet($param = null, $defult = null)
    {
        if($this->getMethod() === 'GET'){
            if($param === null){
                return $_GET;
            }
            return isset($_GET[$param]) ? $_GET[$param] : $defult;
        }
    }

    public function methodPost($param = null, $defult = null)
    {
        if($this->getMethod() === 'POST'){
            if($param === null){
                return $_POST;
            }
            return isset($_POST[$param]) ? $_POST[$param] : $defult;
        }
    }

    public function CookieSet(string $key, string $value, int $time){
        if(!empty($key)){
            setcookie($key, $value , strtotime($time), '/');
        }

    }

    public function CookieGet(string $key = null){
        if(!empty($_COOKIE)){
            if($key === null){
                return $_COOKIE;
            }
            return $_COOKIE[$key];
        }else{return false;}
    }
}
