<?php
namespace app\Controller;


class AccountController extends AbstractController {

    public function loginAction(){
        if (!empty($this->container->get('AccountModel')->user_data)){
            return $this->response->redirect('/main');
        }
        return $this->response->response (['account' => 'login'], ['title' => 'Вход']);
    }

    public function registerAction() {
        if (!empty($this->container->get('AccountModel')->user_data)){
            return $this->response->redirect('/main');
        }
        return $this->response->response (['account' => 'register'], ['title' => 'Регистрация']);

    }

}
