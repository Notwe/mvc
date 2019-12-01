<?php


namespace app\Model;


use app\Model\Database\Database;
use app\Model\Request\Request;

class AccountModel {
    /**
     * This all user params
     * User info                 $user_data
     * Allowed Chats for user    $user_rooms
     * User privilege            $user_privilege
     */
    public $user_data       = [];
    public $user_rooms      = [];
    public $user_privilege  = [];
    /**
     * @var Database $database
     */

    protected $database;

    /**
     * @var Request $request
     */
    protected $request;

    public function __construct (Database $database, Request $request) {
        $this->database  = $database;
        $this->request   = $request;
        $this->userVerification();
    }

    public function getUserData(string $name, string $password){
        $query  = ['name'=>[$name], 'password'=>[$password]];
        $colums = ['id, name, password, user_email'];

        $this->user_data = $this->database->fetch_assoc($this->database->select('user', $query, $colums));
        $this->user_rooms = $this->getUserRooms($name, $password);
        $this->setUserPrivileges($name);
        return true;
    }

    public function findUser(string $name, string $password = '', string $email = ''){
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

    public function userVerification(){
        $login    = trim($this->request->getCookie('login'));
        $password = trim($this->request->getCookie('pass'));

        if(!empty($login) && !empty($password)) {
            if($this->findUser($login, $password) === true){
                $this->getUserData($login, $password);
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
            $this->user_privilege = $this->database->fetch_assoc(
                $this->database->select('user', $join, ['rol_id, privilege.name'])
            );
            return true;
        } else {
            return false;
        }
    }

    protected function getUserRooms (string $name, string $password) {
        $colums_join = ['room.name_room, permission_room.room_id'];
        $query_join  =
            [
                'JOIN'=>['room', 'permission_room.room_id'=>'room.id',
                    'JOIN'=>['user', 'permission_room.user_id ' => 'user.id', 'Type' => 'LEFT']],
                'name'=>[$name], 'password'=>[$password]
            ];
        $rooms    = $this->database->select('permission_room', $query_join, $colums_join);

        while($result = $this->database->fetch_assoc($rooms)){
            $user_rooms[] = $result;

        }
        return $user_rooms;
    }
}
