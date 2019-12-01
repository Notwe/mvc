<?php


namespace app\Model;


class MainModel extends AbstractUserModel {

    public function verify() {
        if (!empty($this->getUserData())) {
            return true;
        }
        return false;
    }
}
