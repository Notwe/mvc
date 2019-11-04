<?php
namespace app\Component;
//TODO переименовать в Routes
//TODO $pages должны приходить извне (из файла конфигурации массивом и передаватся в конструктор)
//TODO $page в $routes
class Routing{
    public $page = [];

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
