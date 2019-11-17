<?php


namespace app\Controller;


class ErrorController {
    protected $container;

    public function __construct ($container) {
        $this->container= $container;
    }

    public function Err404Action() {
        return $this->container->get('ResponseModel')->NoExistResponse(['Errors' => '404']);
    }

    public function Err403Action() {
        return $this->container->get('ResponseModel')->NoExistResponse(['Errors' => '403'], 403);
    }
}