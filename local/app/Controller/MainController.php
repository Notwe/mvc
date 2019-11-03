<?php
namespace app\Controller;
use app\Controller\AbstractController;

class MainController extends AbstractController{

    function MainAction(){
        if($this->check_user_coockie() == false){
            header('location: /');
        }
        return $this->view->getTemplate($this->page_params);

    }

    function GameAction(){
        if($this->check_user_coockie() == false){
            header('location: /');
        }
        return $this->view->getTemplate($this->page_params);

    }

}
