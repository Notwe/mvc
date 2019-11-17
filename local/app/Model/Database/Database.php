<?php

namespace app\Model\Database;

 class Database{
     private $connection;
     private $query_config;

     public function __construct(\mysqli $connection, QueryPrepare $query_config){
         $this->connection = $connection;
         $this->query_config = $query_config;

     }


     public function get_query($request) {
        $this->connection->set_charset("utf8");
        $result = $this->connection->query($request);
        return $result;
     }

     public function escape_string(string $string){
         return $this->connection->escape_string($string);
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

     public function select(string $table, array $queryParam, array $colum = ['*']){
         return $this->get_query($this->query_config->select($table, $queryParam, $colum));
     }
     public function insert( string $table, array $queryParam, array $colum){
         return $this->get_query($this->query_config->insert($table, $queryParam, $colum));
     }

 }