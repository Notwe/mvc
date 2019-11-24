<?php


namespace app\Model;


class RegisterModel extends AbstractModel {

    public function checks_fields(array $post_data){
        $error_messages = [];
        if (empty($post_data['login'])) {
            $error_messages[] = 'Логин не может быть пустым!';
            return $error_messages;
        }
        if (empty($post_data['email'])) {
            $error_messages[] = 'Введите Почту';
            return $error_messages;
        } else {
            if ($this->check_user_email($post_data['email']) == false) {
                $error_messages[] = 'Пользователь с таким Email есть.. Забыл пароль? ';
                return $error_messages;
            }
        }
        if (empty($post_data['pass'])) {
            $error_messages[] = 'Пароль не может быть пустым!';
            return $error_messages;
        }
        if (empty($post_data['pass2'])) {
            $error_messages[] = 'Подтвердите пароль!';
            return $error_messages;
        }
        if ($post_data['pass'] != $post_data['pass2']) {
            $error_messages[] = 'Пароль не совпадает.';
            return $error_messages;
        }
        if (empty($error_messages)) {
            $password = hash('sha256', $post_data['pass']);
            if ($this->find_user($post_data['login']) === true ) {
                $error_messages[] = 'Пользователь с таким именем существует..';
                return $error_messages;

            } else {
                if ($this->register_user($post_data['login'],$password,$post_data['email'])) {
                    $this->user_data = $this->get_user_data($post_data['login'],$password);
                }
                return [];

            }
        }
        return $error_messages;
    }

    public function register() {
        $data = $this->container->get('Request')->getPost();
        if (isset($data) && !empty($data)) {
            $error_message = $this->checks_fields(array_map('trim', $data));
            if (empty($error_message)) {
                $this->request->setCookie(
                    [
                        'login'=> $this->user_data['name'],
                        'pass' => $this->user_data['password'],
                    ]

                );
                return 'true';

            } else {
                return $error_message;

            }
        }
    }

    public function register_user(string $name, string $password, string $email){
        $register = $this->database->insert('user',[[$name], [$password], [$email]],['(name, password, user_email)']);
        if($register){
            return true;
        }else{
            return false;
        }

    }

    public function check_user_email(string $email){
        if(!empty($email)){
            if($this->database->num_rows($this->database->select('user', ['user_email' => [$email]])) >= 1){
                return false;
            }
            return true;
        }
    }
}
