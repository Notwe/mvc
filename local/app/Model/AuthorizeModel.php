<?php


namespace app\Model;


class AuthorizeModel extends AbstractModel {


    public function checks_fields(array $login_post_data){
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
            if ($this->find_user($login_post_data['login'], $password) === true ) {
                $this->get_user_data($login_post_data['login'],$password);
                return [];
            } else {
                $error_messages[] = 'Логин или пароль не совпадают! Попробуйте еще раз...';
                return $error_messages;
            }
        }
        return $error_messages;
    }

    public function autorise(){
        $data = $this->container->get('Request')->getPost();
        if(isset($data)&& !empty($data)){
            $error_message = $this->checks_fields(array_map('trim', $data));
            if(empty($error_message)) {
                $this->request->setCookie(
                    [
                        'login'=> $this->user_data['name'],
                        'pass' => $this->user_data['password'],
                    ]

                );
                return 'true';
            }
            else{
                return $error_message;

            }
        }
    }
}