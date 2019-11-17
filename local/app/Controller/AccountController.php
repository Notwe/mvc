<?php
namespace app\Controller;


class AccountController extends AbstractController{

    public function loginAction(){
        $this->model = $this->bag_models->Authorise;

        return $this->result_action_account('login', 'autorise');
    }

    public function registerAction(){
        $this->model = $this->bag_models->Register;

        return $this->result_action_account('register', 'register');

    }

    private function result_action_account(string $action, $method) {
        if ($this->model->check_user_cookie() === true) {
            $this->response->redirect('/main');
        }

        if (!empty($message = $this->model->{$method}())) {
            return $this->response->json($message);
        }

        return $this->response->response(['account' => $action], $this->page_params);
    }

}
