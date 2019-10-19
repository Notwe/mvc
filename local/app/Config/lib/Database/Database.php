<?php

 namespace app\Config\lib\Database;
 class Database{
     protected $db;


     public function __construct(){
         $database_params = DatabaseConfig::database_data();
         $this->db =  new \Mysqli(
             $database_params['host'],
             $database_params['user'],
             $database_params['password'],
             $database_params['database']
        );
        // if($this->db->connect_error){
        //     die('Ошибка подключения (' . $this->db->connect_errno . ')');
        // }else{
        //     echo 'красава';
        // }

     }


     public function get_query(string $request){
        $this->db->set_charset("utf8");
        $result = $this->db->query($request);
        return $result;
     }

     public function escape_string(string $string){
         return $this->db->escape_string($string);
     }

 }
