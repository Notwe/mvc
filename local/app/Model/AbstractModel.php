<?php

namespace app\Model;

use app\View\Config\PageParams;

abstract class AbstractModel{
    public $user_data;
    private $page_params;
    private $search_user;
    private $query_config;
    private $db;
    public function __construct($database){
        $this->page_params = new PageParams;
        $this->db = $database;

    }
    //Mysql query
    // //$select = SELECT
    // public function get_result_query($table, array $query){
    //     return $this->db->get_query($this->queryConfig->construct_query($table ,$query));
    //
    // }

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

}
