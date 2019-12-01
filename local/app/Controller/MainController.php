<?php
namespace app\Controller;

class MainController extends AbstractController {

    function MainAction() {
        $main_model = $this->container->get('MainModel');
        if ($main_model->verify() === false){
            return $this->response->redirect('/');
        }
        return $this->response->response (
            ['main' => 'main'],
            ['title' => 'Чет', 'user_name'=> $main_model->getUserData('name')]
        );

    }

    function GameAction(){
        if ($this->container->get('MainModel')->verify() === false){
            return $this->response->redirect('/');
        }
        return $this->response->response(['main' => 'game'], ['title' => 'Тест Игра']);

    }

}
