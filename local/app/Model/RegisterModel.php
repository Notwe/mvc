<?php


namespace app\Model;


class RegisterModel extends AbstractModel {

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
}