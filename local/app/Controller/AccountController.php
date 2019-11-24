<?php
namespace app\Controller;


class AccountController extends AbstractController {

    public function loginAction(){
        $this->model      = $this->container->get('AuthorizeModel');
        $this->page_title = 'Авторизация';
        return $this->resultActionAccount('login', 'autorise');
    }

    public function registerAction() {
        $this->model      = $this->container->get('RegisterModel');
        $this->page_title = 'Регистрация';

        return $this->resultActionAccount('register', 'register');

    }

    private function resultActionAccount(string $action, $method) {
        if ($this->model->userCookieVerification() === true) {
            $this->response->redirect('/main');
        }

        if (!empty($message = $this->model->{$method}())) {
            return $this->response->json($message);
        }

        return $this->response->response (
            ['account' => $action],
            ['title' => $this->page_title]
        );
    }

}
