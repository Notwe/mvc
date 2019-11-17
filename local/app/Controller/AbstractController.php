<?php

namespace app\Controller;
use app\Model\BaseModel;


abstract class AbstractController{
    protected $page_params = [];
    protected $user_data = [];
    protected $container;
    protected $response;
    protected $request;
    protected $model;
    /**
     * @var BaseModel $bag_models
     */
    protected $bag_models;


    function __construct($container) {
        $this->container            = $container;
        $this->request              = $container->get('Request');
        $this->response             = $container->get('ResponseModel');
        $this->page_params['title'] = $container->get('Title');
        $this->bag_models           = $container->get('Model');
    }



}
