<?php

namespace app\Model\Database;
class Connection{

    public function __construct (){

        self::connect();
    }

    public static function connect(){
        $database_config = [
            'host'     => 'localhost',
            'user'     => 'dzidzio',
            'password' => 'dzidzio',
            'database' => 'local.lc'
        ];
        $connection = new \Mysqli(
            $database_config['host'],
            $database_config['user'],
            $database_config['password'],
            $database_config['database']
        );
        return $connection;
    }
}
