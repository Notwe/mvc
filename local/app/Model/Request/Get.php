<?php


namespace app\Model\Request;

class Get extends AbstractParameterBag {

    public function getAllGet() {
        return $_GET;
    }
}