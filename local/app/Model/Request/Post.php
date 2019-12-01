<?php


namespace app\Model\Request;

class Post extends AbstractParameterBag {

    public function getAllPost() {
        return $_POST;
    }
}