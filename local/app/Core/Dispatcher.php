<?php

namespace app\Core;

class Dispatcher{
    private $run;
    private $container;


    function __construct($container){
        $this->container = $container;
        $this->run       = $this->container->get('Controller');
    }

    public function display(){
        return $this->run;
    }
}
