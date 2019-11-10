<?php


namespace app\Model;


class AccountModel extends AbstractModel {

    public function register_user(string $name, string $password, string $email){
        $register = $this->insert('user',[[$name], [$password], [$email]],['(name, password, user_email)']);
        if($register){
            return true;
        }else{
            return false;
        }

    }

    public function check_user_email(string $email){
        if(!empty($email)){
            if($this->num_rows($this->select('user', ['user_email' => [$email]])) >= 1){
                return false;
            }
            return true;
        }
    }
}
























?>
