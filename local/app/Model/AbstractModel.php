<?php

namespace app\Model;

abstract class AbstractModel{
    protected $user_data;
    protected $database;
    protected $container;
    protected $request;
    public function __construct($container){
        $this->container = $container;
        $this->request = $container->get('Request');
        $this->database = $container->get('Database');


    }

    public function get_user_data(string $name, string $password){
        $query = ['name'=>[$name], 'password'=>[$password]];
        $colum = ['name, password, rol_id, user_email'];
        $this->user_data = $this->database->fetch_array($this->database->select('user', $query, $colum));
        $columJoin = ['room.name_room, permission_room.room_id'];
        $queryJoin =
            [
            'JOIN'=>['room', 'permission_room.room_id'=>'room.id',
            'JOIN'=>['user', 'permission_room.user_id ' => 'user.id', 'Type' => 'LEFT']],
            'name'=>[$name], 'password'=>[$password]
            ];
        $user_room = $this->database->select('permission_room', $queryJoin, $columJoin);
        while($result = $this->database->fetch_assoc($user_room)){
             $this->user_data[$result['room_id']] = $result['name_room'];

        }
        return $this->user_data;
    }

    public function find_user(string $name, string $password = '', string $email = ''){
        if (!empty($password)) {
            $query = ['name' => [$name] , 'password' => [$password]];
        } else {
            $query = ['name' => [$name]];
        }
        $result = $this->database->select('user', $query);
        if($this->database->num_rows($result) >= 1){
            return true;
        }
        return false;
    }

    public function check_user_cookie(){
        $login = trim($this->request->getCookie('login'));
        $password = trim($this->request->getCookie('pass'));
        if(!empty($login) && !empty($password)) {
            if($this->find_user($login, $password) === true){
                $this->user_data = $this->get_user_data($login, $password);
                $this->page_params[] =  $this->user_data;
                return true;
            }
        }
        $this->request->clearCookie('login');
        $this->request->clearCookie('pass');
        return false;
    }

}
