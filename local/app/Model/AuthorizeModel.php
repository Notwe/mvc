<?php


namespace app\Model;


class AuthorizeModel extends AbstractUserModel {
    private $login;
    private $password;

    public function checksFields(array $login_post_data){
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
            $this->login    = $login_post_data['login'];
            $this->password = hash('sha256', $login_post_data['password']);

            if ($this->findUser($this->login, $this->password) === true ) {
                return [];

            } else {
                $error_messages[] = 'Логин или пароль не совпадают! Попробуйте еще раз...';
                return $error_messages;
            }
        }
        return $error_messages;
    }

    public function autorise(){
        $data = $this->request->getPost();
        if(isset($data)&& !empty($data)){
            $error_message = $this->checksFields(array_map('trim', $data));
            if(empty($error_message)) {
                $this->request->setCookie(
                    [
                        'login'=> $this->login ,
                        'pass' => $this->password,
                    ]

                );
                return ['true'];
            }
            else{
                return $error_message;

            }
        }
    }

    public function userAuthorize() {
        if (!empty($message = $this->autorise())) {
            return $message;
        }

        return false;
    }
}