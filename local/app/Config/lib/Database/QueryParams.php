<?php

namespace app\Config\lib\Database;


class QueryParams{

    protected $database_connection;

    public function __construct($database_connection)
    {
        $this->database_connection = $database_connection;
    }


    public function getQueryParams($params) : array{
        foreach($params as &$param) {
            $param = $this->prepareParamBasedOnType($param);
        }
        return $params;
    }

    /**
     * @param int|double|string|bool|array $param
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
            return $this->database_connection->escape_string($param);
        } elseif(is_array($param)) {
            foreach ($param as $key => $value) {
                return '"' . $this->database_connection->escape_string($value) . '"';
            }
        }
        throw new \Exception('Invalid parameter type of value "' . $param . '"');
    }
}
