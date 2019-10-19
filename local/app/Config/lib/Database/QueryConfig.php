<?php

 namespace app\Config\lib\Database;


class QueryConfig{
    private $db;
    private $params = [];
    public function construct_query(array $query){
        $this->db = new Database;
        if(array_key_exists(50, $query)){
            return $query;
        }
        if(array_key_exists(0, $query)){
            if(!empty($query[0])){
                if($query[0] == 1){
                    return $this->unset_empty_key($this->SELECT($query));
                }
                if($query[0] == 2){
                    return $this->unset_empty_key($this->INSERT($query));
                }
                if($query[0] == 3){
                    return $this->unset_empty_key($this->DELETE($query));
                }
                if($query[0] == 4){
                    return $this->unset_empty_key($this->UPDATE($query));
                }

            }
        }

    }

    public function unset_empty_key($array){
        foreach ($array as $key=>$val){
	        if(empty($val)) unset($array[$key]);
        }
        return $array;
    }

    private function find_array_keys(array $query){
        $query_array = [];
        foreach ($query as $key => $val) {
            if($key != 0){
                if(!empty($query[$key])){
                    $query_array['query_' . $key] = $this->params[$key];
                    if(is_array($val)){
                        if(count($val)>1){
                            foreach ($val as $keys => $value){
                                if(!empty($val[$keys])){
                                    if($keys == 0){
                                        $query_array['paramss_' . $keys] = "('" . $this->db->escape_string($value) . "',";
                                    }else if($keys == count($val)-1){
                                        $query_array['paramss_' . $keys] = "'" . $this->db->escape_string($value) . "')";
                                    }else{
                                    $query_array['paramss_' . $keys] = "'" . $this->db->escape_string($value) . "',";
                                    }
                                }
                            }

                        }else{
                            if(!empty($val[0])){
                            $query_array['params_' . $key] = "'" . $this->db->escape_string($val[0]) . "'";
                            }
                        }
                    }else{
                        $query_array['param_' . $key] = $val;
                    }
                }
            }
        }
        return $query_array;
    }

    private function SELECT($query){
        $this->params = [
            '1' => 'SELECT',
            '2' => 'FROM',
            '3' => 'INNER JOIN',
            '4' => 'ON',
            '5' => '',
            '6' => 'AND',
            '7' => '',                     // 8 10
            '8' => 'INNER JOIN',
            '9' => 'ON',
            '10' => '',
            '11' => 'AND',
            '12' => '',
            '13' => 'WHERE',
            '14' => '',                  // 7 8 10
            '15' => 'AND',
            '16' => '',
            '17' => 'ORDER BY',
            '18' => '',
            '19' => 'LIMIT',
        ];
        // $query_array = [];
        // foreach ($query as $key => $val) {
        //     if($key != 0){
        //         if(!empty($query[$key])){
        //             switch ($key) {
        //                 case '7': $val = "'" . $this->db->escape_string($val) . "'";
        //                 break;
        //                 case '12': $val = "'" . $this->db->escape_string($val) . "'";
        //                 break;
        //                 case '14': $val = "'" . $this->db->escape_string($val) . "'";
        //                 break;
        //                 case '16': $val = "'" . $this->db->escape_string($val) . "'";
        //                 break;
        //                 case '17': $val = "'" . $this->db->escape_string($val) . "'";
        //                 break;
        //                 default: break;
        //             }
        //             $query_array['query_' . $key] = $params[$key];
        //             $query_array['param_' . $key] = $val;
        //         }
        //     }
        // }
        return $this->find_array_keys($query);

    }

    private function DELETE($query){

        $this->params = [
            '1' => 'DELETE FROM',
            '2' => 'WHERE',
            '3' => '',
            '4' => 'AND',
            '5' => '',
        ];
        $query_array = [];
        foreach ($query as $key => $val) {
            if($key != 0){
                if(!empty($query[$key])){
                    switch ($key) {
                        case '3':  $val = "'" . $this->db->escape_string($val) . "'";
                        break;
                        case '5':  $val = "'" . $this->db->escape_string($val) . "'";
                        default: break;
                    }
                    $query_array['query_' . $key] = $params[$key];
                    $query_array['param_' . $key] = $val;
                }
            }
        }
        return $query_array;
    }

    private function UPDATE($query){
        $this->params = [
            '1' => 'UPDATE',
            '2' => 'SET',
            '3' => '',
            '4' => 'WHERE',
            '5' => '',
            '6' => 'AND',
            '7' => '',
        ];
        $query_array = [];
        foreach ($query as $key => $val) {
            if($key != 0){
                if(!empty($query[$key])){
                    switch ($key) {
                        case '3':  $val = "'" . $this->db->escape_string($val) . "'";
                        break;
                        case '5':  $val = "'" . $this->db->escape_string($val) . "'";
                        break;
                        case '7':  $val = "'" . $this->db->escape_string($val) . "'";
                        break;
                        default: break;
                    }
                    $query_array['query_' . $key] = $this->params[$key];
                    $query_array['param_' . $key] = $val;
                }
            }
        }
        return $query_array;
    }

    private function INSERT($query){
        $this->params = [
            '1' => 'INSERT INTO',
            '2' => 'VALUES',
        ];
    return $this->find_array_keys($query);

    }

}
