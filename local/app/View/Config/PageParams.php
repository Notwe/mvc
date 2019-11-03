<?php

namespace app\View\Config;


class PageParams{
    public $dataPage = [];
    public $page_script = [];
    public $user_data = [];

    public function getPageParams(){
        return [
            'page_script' => $this->page_script,
            'user_data' => $this->user_data,

        ];
    }
    // public function getPageParams(){
    //     return $this->Params();
    // }
}
