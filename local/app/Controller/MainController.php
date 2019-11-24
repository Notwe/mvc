<?php
namespace app\Controller;

class MainController extends AbstractController {

    function MainAction(){
        $this->model      = $this->container->get('MainModel');
        $this->page_title = 'Чат';
        if($this->model->check_user_cookie() === false){
            $this->response->redirect('/');
        }
        /**
         * TODO временно тест в процессе
         */
        if($this->container->get('ChatModel')->chat_validation() !== false) {
            return $this->response->json($this->container->get('ChatModel')->chat_validation());
        }
        /**
         * TODO временно тест end
         */
        return $this->response->response (
            ['main' => 'main'],
            ['title' => $this->page_title]
        );

    }

    function GameAction(){
        $this->model = $this->container->get('MainModel');
        $this->page_title = 'Игра';
        if($this->model->check_user_cookie() === false){
            $this->response->redirect('/');
        }

        return $this->response->response(
            ['main' => 'game'],
            ['title' => $this->page_title]
        );

    }

}
