<?php

namespace app\Core;

use app\Model\Container\ServiceContainer;

class Dispatcher{
    /**
     * current user page controller start
     */
    private $run;
    /**
     * @var ServiceContainer $container
     */
    private $container;


    function __construct($container){
        $this->container = $container;
        $this->run       = $this->container->get('Controller');
    }

    public function display(){
        return $this->run;
    }
}
