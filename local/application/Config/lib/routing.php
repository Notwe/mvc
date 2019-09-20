<?php
namespace application\Config\lib;

class Routing{
    public $page = array();

    function __construct(){
        $this->page =
        [
            '' => [
                'controller' => 'main',
                'action' => 'index',
            ],

            'account/login' => [
                'controller' => 'account',
                'action' => 'login',
            ],

            'account/register' => [
                'controller' => 'account',
                'action' => 'register',
            ],

        ];
    }
    public function getPage() {
        return $this->page;
    }
}
