<?php
namespace app\Controller;

class MainController extends AbstractController {

    function MainAction(){
        $this->model      = $this->container->get('MainModel');
        $this->page_title = 'Чат';
        if($this->model->userCookieVerification() === false){
            return $this->container->get('NoAccessResponse');
        }
        /**
         * TODO временно тест в процессе
         */
        if($this->container->get('ChatModel')->chatValidation() !== false) {
            return $this->response->json($this->container->get('ChatModel')->chatValidation());
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
        if($this->model->userCookieVerification() === false){
            return $this->container->get('NoAccessResponse');
        }

        return $this->response->response(
            ['main' => 'game'],
            ['title' => $this->page_title]
        );

    }

}
