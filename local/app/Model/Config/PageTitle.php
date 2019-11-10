<?php


namespace app\Model\Config;


class PageTitle {
    private $title;

    function __construct(){
        $this->title = [
            'index' =>
                ['title' => 'Главная'],
            '404'  =>
                ['title' => 'Ошибка'],
            'register' =>
                ['title' => 'Регистрация'],
            'login'=>
                ['title'=> 'Вход'],
            'main'=>
                ['title'=> 'GOOD'],
            'game'=>
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
