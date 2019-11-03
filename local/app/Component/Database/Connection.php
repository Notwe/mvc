<?php

namespace app\Component\Database;

//TODO вынести в сервис-контейнер
class Connection{

    private $database_config;
    public function __construct(DatabaseConfig $database_config){
        $this->database_config = $database_config->getconfig();
        $connection = new \Mysqli(
            $this->database_config['host'],
            $this->database_config['user'],
            $this->database_config['password'],
            $this->database_config['database']
       );
       return $connection;
    }
}
