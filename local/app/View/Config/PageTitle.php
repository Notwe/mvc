<?php

namespace app\View\Config;

class PageTitle {
    public $title;

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
    public function setTitle(){
        return $this->title;
    }
}
