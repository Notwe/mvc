<?php

namespace app\Component\Database;


class Join{
    private $connection;

    public function __construct(\mysqli $connection){
        $this->connection = $connection;
    }

    public function prepareJoin(array $query, $type = 'INNER'){
        foreach ($query as $key => &$value) {
            if($key == 'JOIN'){
                $value = $this->prepareJoin($query['JOIN']);
            }elseif($key == 'Type'){
                $type = $query['Type'];
            }else{
                $value = $this->prepareParamBasedOnType($value);
            }
        }
        debug($value);

    }


    private function prepareQueryJoin($param){
        if (is_double($param)) {
            return (double) $param;
        } elseif (is_numeric($param)) {
            return (int) $param;
        } elseif (is_bool($param)) {
            return (int) $param;
        } elseif (is_null($param)) {
            return $param;
        } elseif (is_string($param)) {
            return $this->connection->escape_string($param);
        } elseif(is_array($param)) {
            foreach ($param as $key => $value) {
                return '"' . $this->connection->escape_string($value) . '"';
            }
        }
        throw new \Exception('Invalid parameter type of value "' . $param . '"');
    }
}
