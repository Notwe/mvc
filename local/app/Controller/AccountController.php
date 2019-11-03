<?php
namespace app\Controller;
use app\Controller\AbstractController;
class AccountController extends AbstractController{

    public $error_message;

// Autorise
    public function loginAction(){
        if($this->check_user_coockie() === true){
            header('location: /main');
        }
        $this->error_message = 'authorise';
        $this->POST_data();

        return $this->view->getTemplate($this->page_params);
    }



    public function authorise(array $login_post_data){
        $error_messages = [];
        if(empty($login_post_data['login'])){
             $error_messages[] = 'Логин не может быть пустым!<br> Пробуй еще !№1%№?:№;';
             return $error_messages;

        }
        if(empty($login_post_data['password'])){
             $error_messages[] = 'Пароль не может быть пустым!<br> может Забыл ?';
             return $error_messages;

        }
        if(empty($error_messages)){
            $password = hash('sha256', $login_post_data['password']);
            if ($this->model->find_user($login_post_data['login'], $password) === true ){
                $this->user_data = $this->model->get_user_data($login_post_data['login'],$password);
                return [];
            }else {
                $error_messages[] = 'Логин или пароль не совпадают! Попробуйте еще раз...';
                return $error_messages;
            }
        }


        return $error_messages;
    }

//session_is_registered

    public function registerAction(){
        if($this->check_user_coockie() === true){
            header('location: /main');
        }
        $this->error_message = 'register';
        $this->POST_data();

        return $this->view->getTemplate($this->page_params);
    }

    public function register(array $post_data){
	    $error_messages = [];
	    if(empty($post_data['login'])){
		    $error_messages[] = 'Логин не может быть пустым!';
            return $error_messages;
	    }
        if(empty($post_data['email'])){
		    $error_messages[] = 'Введите Почту';
            return $error_messages;
	    }else{
            if($this->model->check_user_email($post_data['email']) == false){
                $error_messages[] = 'Пользователь с таким Email есть.. Забыл пароль? ';
                return $error_messages;
            }
        }
	    if(empty($post_data['pass'])){
		    $error_messages[] = 'Пароль не может быть пустым!';
            return $error_messages;
	    }
	    if(empty($post_data['pass2'])){
		    $error_messages[] = 'Подтвердите пароль!';
            return $error_messages;
	    }
	    if($post_data['pass'] != $post_data['pass2']){
		   $error_messages[] = 'Пароль не совпадает.';
           return $error_messages;
	    }
	    if(empty($error_messages)){
            $password = hash('sha256', $post_data['pass']);
            if ($this->model->find_user($post_data['login']) === true ){
                $error_messages[] = 'Пользователь с таким именем существует..';
                return $error_messages;

            }else{
                //$this->model->get_user_data($post_data['login'],$password);
                if($this->model->register_user($post_data['login'],$password,$post_data['email'])){
                    $this->user_data = $this->model->get_user_data($post_data['login'],$password);
                }
                return [];

            }
	    }
	    return $error_messages;
    }


    public function POST_data(){
        $data = $this->request->methodPost();
        if(isset($data)&& !empty($data)){
            $error_message = $this->{$this->error_message}(array_map('trim',$_POST));
            if(empty($error_message)) {
                $this->request->CookieSet('login', $this->user_data['name'], time() +100000);
                $this->request->CookieSet('pass', $this->user_data['password'], time() +100000);
                exit;
            }
            else{
                echo json_encode($error_message);
                exit;
            }
        }
    }

}
