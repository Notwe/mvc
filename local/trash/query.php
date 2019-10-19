<?php

public function unset_array_empty_key($array){
    foreach ($array as $key=>$val){
        if(empty($val)) unset($array[$key]);
    }
    return $array;
}

private function SELECT($query){

    if(array_key_exists(1, $query)){
        if(!empty($query[1])){
            $select = "SELECT $query[1] ";
        }
    }else{
        $select = '';
    }
    if(array_key_exists(2, $query)){
        if(!empty($query[2])){
            $from = "FROM $query[2] ";
        }
    }else{
        $from = '';
    }
    if(array_key_exists(3, $query)){
        if(!empty($query[3])){
            $where = "WHERE $query[3]=";
        }
    }else{
        $where = '';
    }
    if(array_key_exists(4, $query)){
        if(!empty($query[4])){
            $query[4] = $this->db->escape_string($query[4]);
            $whereStr = "'$query[4]' ";
        }
    }else{
        $whereStr = '';
    }
    if(array_key_exists(5, $query)){
        if(!empty($query[5])){
            $and = "AND $query[5]=";
        }else{
            $and = '';
        }
    }else{
        $and = '';
    }
    if(array_key_exists(6, $query)){
        if(!empty($query[6])){
            $query[6] = $this->db->escape_string($query[6]);
            $andStr = "'$query[6]' ";
        }
    }else{
        $andStr = '';
    }
    if(array_key_exists(7, $query)){
        if(!empty($query[7])){
            $innerjoin = "INNER JOIN $query[7] ";
        }
    }else{
        $innerjoin = '';
    }
    if(array_key_exists(8, $query)){
        if(!empty($query[8])){
            $innerjoinON = "ON $query[8]=";
        }
    }else{
        $innerjoinON = '';
    }
    if(array_key_exists(9, $query)){
        if(!empty($query[9])){
            $innerjoinONstr = "$query[9] ";
        }
    }else{
        $innerjoinONstr = '';
    }
    if(array_key_exists(10, $query)){
        if(!empty($query[10])){
            $innerjoinAND = "AND $query[10]=";
        }
    }else{
        $innerjoinAND = '';
    }
    if(array_key_exists(11, $query)){
        if(!empty($query[11])){
            $query[11] = $this->db->escape_string($query[11]);
            $innerjoinANDstr = "'$query[11]' ";
        }
    }else{
        $innerjoinANDstr = '';
    }
    if(array_key_exists(12, $query)){
        if(!empty($query[12])){
            $innerjoin2 = "INNER JOIN $query[12] ";
        }
    }else{
        $innerjoin2 = '';
    }
    if(array_key_exists(13, $query)){
        if(!empty($query[13])){
            $innerjoinON2 = "ON $query[13]=";
        }
    }else{
        $innerjoinON2 = '';
    }
    if(array_key_exists(14, $query)){
        if(!empty($query[14])){
            $innerjoinONstr2 = "$query[14] ";
        }
    }else{
        $innerjoinONstr2 = '';
    }
    if(array_key_exists(15, $query)){
        if(!empty($query[15])){
            $innerjoinAND2 = "AND $query[15]=";
        }
    }else{
        $innerjoinAND2 = '';
    }
    if(array_key_exists(16, $query)){
        if(!empty($query[16])){
            $query[16] = $this->db->escape_string($query[16]);
            $innerjoinANDstr2 = "'$query[16]' ";
        }
    }else{
        $innerjoinANDstr2 = '';
    }
    if(array_key_exists(17, $query)){
        if(!empty($query[17])){
            $query[17] = $this->db->escape_string($query[17]);
            $order = "'$query[17]' ";
        }
    }else{
        $order = '';
    }
    if(array_key_exists(18, $query)){
        if(!empty($query[18])){
            $query[18] = $this->db->escape_string($query[18]);
            $limit = "'$query[18]' ";
        }
    }else{
        $limit = '';
    }
    if(array_key_exists(19, $query)){
        if(!empty($query[19])){
            $query[19] = $this->db->escape_string($query[19]);
            $typelimit = "'$query[19]' ";
        }
    }else{
        $typelimit = '';
    }

    $query_result = [
        '1' => $select, // SELECT
        '2'=> $from, //FROM
        '3' => $innerjoin, // INNERJOIN <-
        '4' => $innerjoinON, // INNERJOIN ON str
        '5' => $innerjoinONstr, // INNERJOIN ON str = str
        '6' => $innerjoinAND, // INNERJOIN AND str
        '7' => $innerjoinANDstr,// INNERJOIN AND str = str
        '8' => $innerjoin2,// INNERJOIN
        '9' => $innerjoinON2,// INNERJOIN ON
        '10' => $innerjoinONstr2,// INNERJOIN ON str = str
        '11' => $innerjoinAND2,// INNERJOIN AND str
        '12' => $innerjoinANDstr2,// INNERJOIN AND str = str
        '13' => $where, //WHERE str
        '14' => $whereStr,//WHERE str = str
        '15' => $and, //AND str
        '16' => $andStr,//AND str =  str
        '17' => $order,// ORDER BY
        '18' => $limit,// LIMIT
        '19' => $typelimit,// TYPE LIMIT DESC = 1 or ASC = 2

    ];



    return $this->unset_array_empty_key($query_result);

}



<?php
[
    'Select'=>,
    'From'=>,
    'Where'=>,
    'WhereStr'=>,
    'And'=>,
    'AndStr'=>,
    'InnerJoin'=>,
    'InnerJoinOn'=>,
    'InnerjoinAND'=>,
    'InnerjoinANDstr'=>,
    'InnerJoin2'=>,
    'InnerJoinOn2'=>,
    'InnerJoinAND2'=>,
    'InnerJoinANDstr2'=>,
    'Order'=>,
    'Limit'=>,

];


public function get_array_query(array $query){
    if(empty($query[0]))


    $from = 'FROM ' . $from;
    if(!empty($select)){
        $select = 'SELECT ' . $this->db->escape_string($select);
    }else{
        $select = 'SELECT *';
    }
    if(!empty($innerjoin)){
        $innerjoin = 'INNER JOIN ' . $this->db->escape_string($innerjoin);
        $innerjoinON = 'ON ' . $this->db->escape_string($innerjoinON);
        if(!empty($innerjoinAND)){
            $innerjoinAND = 'AND' . $this->db->escape_string($innerjoinAND);
        }
    }
    if(!empty($innerjoin2)){
        $innerjoin2 = 'INNER JOIN ' . $this->db->escape_string($innerjoin2);
        $innerjoinON2 = 'ON ' . $this->db->escape_string($innerjoinON2);
        if(!empty($innerjoinAND2)){
            $innerjoinAND2 = 'AND' . $this->db->escape_string($innerjoinAND2);
        }
    }
    if(!empty($where)){
        $where = ' WHERE' . $where . '= ';
        $whereString = $this->db->escape_string($whereString);
        if(!empty($and)){
            $and = 'AND' . $and . '=';
            $andString = $this->db->escape_string($andString);
        }
    }
    if(!empty($order)){
        $order = 'ORDER BY ' . $this->db->escape_string($order);
    }
    if(!empty($limit)){
        $limit = 'DESC LIMIT ' . $this->db->escape_string($limit);
    }

    $query = [
        //'custom' => $custom,
        'select' => $select,
        'from'=> $from,
        'where' => $where,
        'whereString' => $whereString,
        'and' => $and,
        'andString' => $andString,
        'innerjoin' => $innerjoin,
        'innerjoinON' => $innerjoinON,
        'innerjoinAND' => $innerjoinAND,
        'innerjoin2' => $innerjoin2,
        'innerjoinON2' => $innerjoinON2,
        'innerjoinAND2' => $innerjoinAND2,
        'order' => $order,
        'limit' => $limit,
    ];
    return $this->get_result_query($query);
}



// 1 = SELECT
// 2 = From
