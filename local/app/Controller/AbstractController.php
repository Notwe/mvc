<?php

namespace app\Controller;
use app\Model\Container\ServiceContainer;
use app\Model\Request\Request;
use app\Model\Response\ResponseModel;


abstract class AbstractController{
    protected $page_params = [];
    protected $user_data = [];
    /**
     * @var ServiceContainer $container
     */
    protected $container;
    /**
     * @var ResponseModel $response
     */
    protected $response;
    /**
     * @var Request $request
     */
    protected $request;
    /**
     * Page Title
     */
    protected $page_title;


    function __construct($container) {
        $this->container   = $container;
        $this->request     = $this->container->get('Request');
        $this->response    = $this->container->get('ResponseModel');
    }



}
