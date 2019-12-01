<?php

 namespace app\Model\Database;


class QueryPrepare{
    private $connection;
    private $join;

    function __construct($connection, Join $join){
        $this->connection = $connection;
        $this->join = $join;
    }

    public function deleted(string $table, $where){
        $query = 'DELETE FROM ' . $table . ' ' . $this->queryToString($where);
        return $query;
    }

    public function select(string $table, array $query_Params = [], array $columns){
        $query = 'SELECT ' . implode(', ', $columns) . ' FROM ' . $table . ' ' . $this->queryToString($query_Params);
        return $query;
    }

    public function insert(string $table, array $inser_params, array $colums){
        $query =
            'INSERT INTO ' . $table .
            ' (' . implode(', ', $colums) . ') ' .
            'VALUES ('. implode(',', $this->getQueryParams($inser_params)) .')';
        return $query;
    }
    public function update(string $table, array $set_params, array $where){
        $query =
            'UPDATE ' . $table .
            ' SET '   . implode(' = ' , $this->constructQueryString($set_params)).
            ' WHERE ' . implode(' AND ', $this->constructQueryString($where));
        return $query;
    }

    protected function queryToString(array $query){
        $limit = '';
        $order = '';
        $result_string = '';

        if (array_key_exists('JOIN', $query)) {
            $join_query = $this->join->prepareJoin($query['JOIN']);
            $result_string .= ' ' . $join_query;
            unset($query['JOIN']);
        }

        if(array_key_exists('LIMIT', $query)){
            $limit = $this->prepareLimit($query['LIMIT']);
            unset($query['LIMIT']);
        }

        if(array_key_exists('ORDER',$query )) {
            $order = $this->prepareOrderBy($query['ORDER']);
            unset($query['ORDER']);
        }
        /**
         * this key WHERE is used if request not equal =
         */
        if(array_key_exists('WHERE', $query)) {
            $where = $this->prepareWhere($query['WHERE']);
            return $result_string . $where .$order . $limit;
        }

        $result = $this->constructQueryString($query);
        if (!empty($result)) {
            $result_string .= ' WHERE ' . implode(' AND ', $result) . ' ';
        }
        return $result_string . $order . $limit;
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

    protected function prepareParamBasedOnType($param) {
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

    protected function prepareLimit(array $limit) {
        foreach ($limit as $type => $params) {
            $result = $type . ' LIMIT ' . $this->prepareParamBasedOnType($params);
        }
        return $result;
    }
    protected function prepareOrderBy (array $order) {
        foreach ($order as $type => $params) {
            $result = 'ORDER ' . $type . ' ' . $this->prepareParamBasedOnType($params) . ' ';
        }
        return $result;
    }
    protected  function prepareWhere (array $where) {
        foreach ($where as $key => $value) {
            $result = $key . '' .  $this->prepareParamBasedOnType($value) . ' ';
        }
        return $result;
    }

}
