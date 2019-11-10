<?php

 namespace app\Model\Database;


class QueryPrepare{
    private $connection;
    private $join;

    function __construct($connection){
        $this->connection = $connection;
    }

    public function deleteQuery(string $table, $where){
        return $this->database_connection->query('DELETE FROM ' . $table . ' ' . $this->QueryToString($where));
    }

    public function selectQuery(string $table, array $query_Params = [], array $columns){
        $query = 'SELECT ' . implode(', ', $columns) . ' FROM ' . $table . ' ' . $this->QueryToString($query_Params);
        return $query;
    }
    //TODO форматирование!!!
    public function insertQuery(string $table, array $inser_tparams, array $colums){
        $query =
        'INSERT INTO ' . $table . ' ' . implode(', ', $colums) . ' VALUES ('.
        implode(',', $this->queryParams->getQueryParams($inser_tparams))
        .')';
        return $query;
    }
    public function updateQuery(){
        //
    }

    protected function QueryToString(array $query){

        $result_string = '';
        if (array_key_exists('JOIN', $query)) {
            $prepeareJoin = $this->join->prepareJoin($query['JOIN']);
            foreach ($prepeareJoin as $join_query) {
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

        $result = $this->getQueryParams($query);

        $result_array = [];

        foreach ($result as $column => $value) {
            $result_array[] = $column . ' = ' . $value;
        }
        return $result_array;
    }


    public function getQueryParams($params) : array{
        foreach($params as &$param) {
            $param = $this->prepareParamBasedOnType($param);
        }
        return $params;
    }

    /**
     * TODO дублирование кода
     * "@see Join::prepareQueryJoin()
     *
     * @param int|double|string|bool|array $param
     *
     * @param $param
     *
     * @return float|int|string
     * @throws \Exception
     */
    protected function prepareParamBasedOnType($param)
    {
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
