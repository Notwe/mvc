<?php


namespace app\Model;


class RegisterModel extends AbstractUserModel {
    private $login;
    private $password;

    public function checksFields(array $post_data){
        $error_messages = [];
        if (empty($post_data['login'])) {
            $error_messages[] = 'Логин не может быть пустым!';
            return $error_messages;
        }
        if (empty($post_data['email'])) {
            $error_messages[] = 'Введите Почту';
            return $error_messages;
        } else {
            if ($this->checkUserEmail($post_data['email']) == false) {
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
            $this->login    = $post_data['login'];
            $this->password = hash('sha256', $post_data['pass']);

            if ($this->findUser($post_data['login']) === true ) {
                $error_messages[] = 'Пользователь с таким именем существует..';
                return $error_messages;

            } else {
                if ($this->register($this->login, $this->password,$post_data['email'])) {
                    return [];
                }
                return $error_messages[] = 'Ошибка регистрации , попробуйте позже...';

            }
        }
        return $error_messages;
    }

    public function registerUser() {
        $data = $this->request->getPost();
        if (isset($data) && !empty($data)) {
            $error_message = $this->checksFields(array_map('trim', $data));
            if (empty($error_message)) {
                $this->request->setCookie(
                    [
                        'login'=> $this->login,
                        'pass' => $this->password,
                    ]

                );
                return ['true'];

            } else {
                return $error_message;

            }
        }
    }

    public function register(string $name, string $password, string $email){
        $register = $this->database->insert('user',[[$name], [$password], [$email]],['(name, password, user_email)']);
        if($register){
            return true;
        }else{
            return false;
        }

    }

    public function checkUserEmail(string $email){
        if(!empty($email)){
            if($this->database->num_rows($this->database->select('user', ['user_email' => [$email]])) >= 1){
                return false;
            }
            return true;
        }
    }

    public function userRegisterAction () {

    }
}