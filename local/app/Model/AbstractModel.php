<?php

namespace app\Model;
use app\Config\lib\Database\QueryConfig;
use app\Config\lib\Database\Database;
use app\View\lib\PageParams;

abstract class AbstractModel{
    public $user_data;
    public $db;
    private $page_params;
    private $search_user;
    private $queryConfig;
    public function __construct(){
        $this->db = new Database;
        $this->page_params = new PageParams;
        $this->queryConfig = new QueryConfig($this->db);

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
        // $user_room = $this->get_result_query(
        //     ['1', 'room.name_room, permission_room.room_id','permission_room',
        //     'room','permission_room.room_id =', 'room.id',
        //     '8'=>'user', 'permission_room.user_id =', 'user.id',
        //     '13'=>'name=', [$name] , 'password=', [$password]
        //     ]
        // );
        // while($result = $this->fetch_assoc($user_room)){
        //      $this->user_data[$result['room_id']] = $result['name_room'];
        //
        // }
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
        return $this->db->get_query($this->queryConfig->selectQuery($table, $queryParam, $colum));
    }
    public function insert( string $table, array $queryParam, array $colum){
        return $this->db->get_query($this->queryConfig->insertQuery($table, $queryParam, $colum));
    }

}
