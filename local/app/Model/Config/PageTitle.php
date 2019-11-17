<?php


namespace app\Model\Config;


class PageTitle {
    private $title;

    function __construct(){
        $this->title = [
            'indexAction' =>
                ['title' => 'Главная'],
            '404Action'  =>
                ['title' => 'Ошибка'],
            'registerAction' =>
                ['title' => 'Регистрация'],
            'loginAction'=>
                ['title'=> 'Вход'],
            'mainAction'=>
                ['title'=> 'GOOD'],
            'gameAction'=>
                ['title'=> 'PAC-MAN'],
        ];
    }
    public function get(string $page){
        if (array_key_exists($page, $this->title)) {
            return $this->title[$page]['title'];
        }
        return '';
    }
}
