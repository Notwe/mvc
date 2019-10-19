<?php
namespace app\Controller\lib;
use app\Controller\AbstractController;

class IndexController extends AbstractController{

    function IndexAction(){
        $this->view->getTemplate($this->page_params);
        if($this->check_user_coockie() === true){
            header('location: /main');
        }

    }

}
