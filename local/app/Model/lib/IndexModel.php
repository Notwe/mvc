<?php

namespace app\Model\lib;
use app\Model\AbstractModel;


class IndexModel extends AbstractModel {

    public function __construct(){
        parent::__construct();
    }


    public function result(){
        $result = $this->db->get_query('SELECT * FROM messages');
        return $result->fetch_all();
    }

}
