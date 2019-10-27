<?php

 namespace app\Config\lib\Database;


class QueryConfig{
    private $db;
    private $params = [];
    private $queryParams;


    function __construct($db){
        $this->db = $db;
        $this->queryParams = new QueryParams($db);

    }
    // public function construct_query(string $table, array $query){
    //     if(array_key_exists(50, $query)){
    //         return $query;
    //     }
    //     if(array_key_exists(0, $query)){
    //         if(!empty($query[0])){
    //             if($query[0] == 1){
    //                 return $this->SELECT($table, $this->QueryToString($query));
    //             }
    //             if($query[0] == 2){
    //                 return $this->INSERT($query);
    //             }
    //             if($query[0] == 3){
    //                 return $this->DELETE($query);
    //             }
    //             if($query[0] == 4){
    //                 return $this->UPDATE($query);
    //             }
    //
    //         }
    //     }
    //
    // }

    public function deleteQuery(string $table, $where){
        return $this->database_connection->query('DELETE FROM ' . $table . ' ' . $this->QueryToString($where));
    }

    public function selectQuery(string $table, array $queryParams = [], array $columns){
        $query = 'SELECT ' . implode(', ', $columns) . ' FROM ' . $table . ' ' . $this->QueryToString($queryParams);
        return $query;
    }

    public function insertQuery(string $table, array $insertparams, array $colums){
        $query =
        'INSERT INTO ' . $table . ' ' . implode(', ', $colums) . ' VALUES ('.
        implode(',', $this->queryParams->getQueryParams($insertparams))
        .')';
        return $query;
    }
    public function updateQuery(){
        //
    }

    protected function QueryToString(array $query){

        $result_string = '';
        if (array_key_exists('JOIN', $query)) {
            foreach ($query['JOIN'] as $join_query) {
                $result_string .= ' ' . $join_query;
            }
            unset($query['JOIN']);
        }
        if(array_key_exists('LIMIT', $query)){
            //unset($query['LIMIT']);
        }
        if(array_key_exists('ORDER',$query )){
            //unset($query['ORDER']);
        }
        // if(array_key_exists('INSERT',$query )){
        //     $result = $this->constructQueryString($query['INSERT']);
        //     if (!empty($result)) {
        //         return implode(' , ', $result);
        //     }
        // }
        $result = $this->constructQueryString($query);
        if (!empty($result)) {
            $result_string .= ' WHERE ' . implode(' AND ', $result);
        }
        return $result_string;
    }
    //
    //
    protected function constructQueryString(array $query){

        $result = $this->queryParams->getQueryParams($query);

        $result_array = [];

        foreach ($result as $column => $value) {
            $result_array[] = $column . ' = ' . $value;
        }
        return $result_array;
    }

}
