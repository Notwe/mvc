<?php
namespace app\Component;

class Routing{
    public $page = array();

    function __construct(){
        $this->page =
        [
            'main' => [
                'controller' => 'main',
                'action' => 'main',
            ],
            'main/game' => [
                'controller' => 'main',
                'action' => 'game',
            ],

            '' => [
                'controller' => 'index',
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
            'account/user' => [
                'controller' => 'user',
                'action' => 'user',
            ],
        ];
    }
    public function getPage() {
        return $this->page;
    }
}
