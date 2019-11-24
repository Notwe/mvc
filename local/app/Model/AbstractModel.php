<?php

namespace app\Model;

use app\Model\Database\Database;
use app\Model\Request\Request;

abstract class AbstractModel {
    /**
     * This all user params
     * User info                 $user_data
     * Allowed Chats for user    $user_rooms
     * User privilege            $user_privilege
     */
    public $user_rooms = [];
    protected $user_data = [];
    protected $user_privilege = [];
    /**
     * @var Database $database
     */
    protected $database;
    /**
     * @var ServiceContainer $container
     */
    protected $container;
    /**
     * @var Request $request
     */
    protected $request;


    public function __construct($container){
        $this->container = $container;
        $this->request   = $this->container->get('Request');
        $this->database  = $this->container->get('Database');


    }

    public function get_user_data(string $name, string $password){
        $query  = ['name'=>[$name], 'password'=>[$password]];
        $colums = ['name, password, user_email'];

        $this->user_data = $this->database->fetch_assoc($this->database->select('user', $query, $colums));

        $colums_Join = ['room.name_room, permission_room.room_id'];
        $query_Join  =
            [
            'JOIN'=>['room', 'permission_room.room_id'=>'room.id',
            'JOIN'=>['user', 'permission_room.user_id ' => 'user.id', 'Type' => 'LEFT']],
            'name'=>[$name], 'password'=>[$password]
            ];
        $user_room    = $this->database->select('permission_room', $query_Join, $colums_Join);

        while($result = $this->database->fetch_assoc($user_room)){
             $this->user_rooms[] = $result;

        }
        $this->setUserPrivileges($name);
        return true;
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
        $login    = trim($this->request->getCookie('login'));
        $password = trim($this->request->getCookie('pass'));

        if(!empty($login) && !empty($password)) {
            if($this->find_user($login, $password) === true){
                $this->get_user_data($login, $password);
                return true;
            }
        }
        $this->request->clearCookie('login');
        $this->request->clearCookie('pass');
        return false;
    }

    public function setUserPrivileges (string $name) {
        if (!empty($name)) {
            $join = ['JOIN' => ['privilege', 'privilege.id' => 'user.rol_id'],'user.name' => [$name]];
            $this->user_privilege = $this->database->fetch_array(
                $this->database->select('user', $join, ['rol_id, privilege.name'])
            );
            return true;
        } else {
            return false;
        }
    }

}
