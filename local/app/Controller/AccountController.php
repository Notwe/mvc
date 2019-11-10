<?php
namespace app\Controller;
class AccountController extends AbstractController{
    private $action;

    public function loginAction(){
        $this->model = $this->getModel('Authorise');
//        if($this->model->check_user_cookie() === true){
//            $this->response->redirect('/main');
//        }
        $this->action = 'authorise';
        if (empty($this->POST_data())){

            return $this->response->create($this->view::render($this->path,['title'=> $this->page_title]));
        } else {
            return $this->POST_data();
        }
    }

    public function registerAction(){
        $this->model = $this->getModel('Register');
//        if($this->model->check_user_cookie() === true){
//            $this->response->redirect('/main');
//        }
        $this->error_message = 'register';
        $this->POST_data();

        return $this->view->getTemplate($this->page_params);
    }


    public function POST_data(){
        $data = $this->container->get('Request')->getPost()->get('', true);
        if(isset($data)&& !empty($data)){
            $error_message = $this->model->{$this->action}(array_map('trim', $_POST));
            if(empty($error_message)) {
                // тут добавить куки
                return true;

            }
            else{
                return $this->response->setJson($error_message);

            }
        }
    }

}
