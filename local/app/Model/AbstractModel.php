<?php

namespace app\Model;

abstract class AbstractModel{
    public $user_data;
    private $database;
    public function __construct($container){
        $this->database = $container->get('Database');

    }

    public function num_rows(object $query){
        if($query->num_rows > 0)
        return $query->num_rows;
    }

    public function fetch_assoc(object $query){
        if(!empty($query)){
            return $query->fetch_assoc();
        }
    }

    public function fetch_array($query){
        if(!empty($query)){
            return $query->fetch_array();
        }
    }

    public function get_user_data(string $name, string $password){
        $query = ['name'=>[$name], 'password'=>[$password]];
        $colum = ['name, password, rol_id, user_email'];
        $this->user_data = $this->fetch_array($this->select('user', $query, $colum));
        $columJoin = ['room.name_room, permission_room.room_id'];
        $queryJoin = ['JOIN'=>[
            'room', 'permission_room.room_id'=>'room.id','JOIN'=>[
            'user', 'permission_room.user_id ' => 'user.id']],
            'name'=>[$name], 'password'=>[$password]];
        debug($queryJoin);
        $user_room = $this->select('permission_room', $queryJoin, $columJoin);
        while($result = $this->fetch_assoc($user_room)){
             $this->user_data[$result['room_id']] = $result['name_room'];

        }
        return $this->user_data;
    }

    public function find_user(string $name, string $password = '', string $email = ''){
        if(!empty($password)){
            $query = ['name' => [$name] , 'password' => [$password]];
        }else{
            $query = ['name' => [$name]];
        }
        $result = $this->select('user', $query);
        if($this->num_rows($result) >= 1){
            return true;
        }
        return false;
    }

    public function select(string $table, array $queryParam, array $colum = ['*']){
        return $this->db->get_query($table, $queryParam, $colum);
    }
    public function insert( string $table, array $queryParam, array $colum){
        return $this->db->get_query($this->queryConfig->insertQuery($table, $queryParam, $colum));
    }

    public function check_user_cookie(){
        echo '123';
        $login = trim($this->request->CookieGet('login'));
        $password = trim($this->request->CookieGet('pass'));
        if(!empty($login) && !empty($password)){
            if($this->model->find_user($login, $password) === true){
                $this->user_data = $this->model->get_user_data($login, $password);
                $this->page_params->user_data = $this->user_data;
                return true;
            }
        }
        $this->request->CookieSet('login', '', time() -100500);
        $this->request->CookieSet('pass', '', time() -100500);
        return false;
    }

}
