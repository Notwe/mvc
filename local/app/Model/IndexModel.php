<?php

namespace app\Model;
use app\Model\AbstractModel;


class IndexModel extends AbstractModel {
    public function result(){
        $result = $this->db->get_query('SELECT * FROM messages');
        return $result->fetch_all();
    }

}
