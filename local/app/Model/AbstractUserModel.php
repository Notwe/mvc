<?php

namespace app\Model;

use app\Model\Database\Database;
use app\Model\Request\Request;
use app\Model\Response\ResponseModel;

abstract class AbstractUserModel {
    /**
     * @var Database $database
     */
    protected $database;
    /**
     * @var Request $request
     */
    protected $request;
    /**
     * @var ResponseModel $response
     */
    protected $response;
    /**
     * @var AccountModel $account
     */
    protected $account;


    public function __construct
        (
            Request       $request,
            ResponseModel $response,
            Database      $database,
            AccountModel  $account
        ){
        $this->request   = $request;
        $this->database  = $database;
        $this->response  = $response;
        $this->account   = $account;

    }

    /**
     * @param string $param
     * if $param , then return string  user_data[$param]
     * else return array all user_data
     * @return array|string
     */
    public function getUserData(string $param = ''){
        if (!empty($param)) {
            return $this->account->user_data[$param];
        }
        return $this->account->user_data;
    }

    public function getUserRooms($default = false) {
        if ($default === false) {
            $hash_user_room = $this->account->user_rooms;
            foreach ($hash_user_room as &$params){
                $params['room_id'] = hash('crc32', $params['room_id']);
            }
            return $hash_user_room;
        }
        return $this->account->user_rooms;
    }

    public function getUserPermission() {
        return $this->account->user_privilege;
    }

    public function findUser(string $name, string $password = '', string $email = '') {
        return $this->account->findUser($name, $password);
    }



}
