<?php
namespace app\Component\Database;

/**
 * TODO Дублирование функцонала
 * @see Connection
 *
 * Class DatabaseConfig
 * @package app\Component\Database
 */
class DatabaseConfig{
    private $params;
    public function __construct(){
        $this->params = [
            'host'     => 'localhost',
            'user'     => 'dzidzio',
            'password' => 'dzidzio',
            'database' => 'local.lc'
        ];


    }
    public function getconfig(){
        return $this->params;
    }
}
