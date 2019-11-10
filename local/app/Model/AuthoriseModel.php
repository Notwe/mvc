<?php


namespace app\Model;


class AuthoriseModel extends AbstractModel {


    public function authorise(array $login_post_data){
        $error_messages = [];
        if(empty($login_post_data['login'])){
            $error_messages[] = 'Логин не может быть пустым!<br> Пробуй еще !№1%№?:№;';
            return $error_messages;

        }
        if (empty($login_post_data['password'])) {
            $error_messages[] = 'Пароль не может быть пустым!<br> может Забыл ?';
            return $error_messages;

        }
        if(empty($error_messages)){
            $password = hash('sha256', $login_post_data['password']);
            if ($this->model->find_user($login_post_data['login'], $password) === true ) {
                $this->user_data = $this->model->get_user_data($login_post_data['login'],$password);
                return [];
            } else {
                $error_messages[] = 'Логин или пароль не совпадают! Попробуйте еще раз...';
                return $error_messages;
            }
        }


        return $error_messages;
    }
}