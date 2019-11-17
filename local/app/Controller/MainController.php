<?php
namespace app\Controller;

class MainController extends AbstractController{

    function MainAction(){
        $this->model = $this->bag_models->Main;

        if($this->model->check_user_cookie() === false){
            $this->response->redirect('/');
        }

        return $this->response->response(['main' => 'main'], $this->page_params);

    }

    function GameAction(){
        $this->model = $this->bag_models->Main;

        if($this->model->check_user_cookie() === false){
            $this->response->redirect('/');
        }

        return $this->response->response(['main' => 'game'], $this->page_params);

    }

}
