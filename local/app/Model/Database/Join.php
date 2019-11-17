<?php

namespace app\Model\Database;


class Join {
    private $connection;
    public function __construct ($connection) {
        $this->connection = $connection;
    }

    public function prepareJoin(array $query, $type = 'INNER'){
        $join = '';
        $result_array = [];
        if (array_key_exists('Type', $query)) {
            $type = $query['Type'];
            unset($query['Type']);
        } else if (array_key_exists('JOIN', $query)){
            $join = $this->prepareJoin($query['JOIN']);
            unset($query['JOIN']);
        }
        $result_string = $type . '';
        foreach ($query as $colums => &$value) {
            if (!is_numeric($colums)) {
                if (is_array($value)) {
                    foreach ($value as $key => $param) {
                        $value =  '"' . $this->connection->escape_string($param) . '"';
                    }
                }
                $result_array[] = $colums . ' = ' . $value;
            }else {
                $result_string .= ' JOIN ' . $value;
            }
        }
        $result_string .= ' ON ' . implode(' AND ', $result_array) . ' ' .$join;
        return $result_string;
    }
}
