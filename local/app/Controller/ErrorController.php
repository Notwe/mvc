<?php


namespace app\Controller;


class ErrorController {
    protected $container;

    public function __construct ($container) {
        $this->container= $container;
    }

    public function Error404Action() {
        return $this->container->get('ResponseModel')->NotFoundResponse(404);
    }

    public function Error403Action() {
        return $this->container->get('ResponseModel')->NoAccessResponse(403);
    }
}