<?php

namespace app\Component;
use app\Component\Database\QueryConfig;
use app\Component\Database\Connection;

 class Database{
     private $connection;
     private $query_config;

     public function __construct(\mysqli $connection, QueryConfig $query_config){
         $this->connection = $connection;
         $this->query_config = $query_config;

     }


     public function get_query(string $table, array $request, $colum){
        $requeststr = $this->query_config->selectQuery($table, $request, $colum);
        $this->connection->set_charset("utf8");
        $result = $this->connection->query($requeststr);
        return $result;
     }

     public function escape_string(string $string){
         return $this->connection->escape_string($string);
     }

 }