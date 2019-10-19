<?php

namespace app\View;
use app\View\lib\PageTitle;
use app\View\lib\PageParams;
class View{
    public $template_path;
    public $general_template = 'general';
    public $title = [];

    function __construct($path){
        $this->template_path = $path['controller']. '/' .$path['action'];
        $title = new PageTitle;
        $title = $title->setTitle();
        $this->title = $title[$path['action']]['title'];
    }
    public function getTemplate($page_params){
        $page_params->page_script = $this->PageJs();
        extract($page_params->getPageParams());
        $title = $this->title;
        if(file_exists(__DIR__ . '/Template/' . $this->template_path . '.tpl')){
            ob_start();
      	    include_once __DIR__ . '/Template/' . $this->template_path . '.tpl';
      	    $page_data = ob_get_clean();
      	    include_once __DIR__ . '/Template/' . $this->general_template . '.tpl';
        }else{
            //error
            $this->errorPage('404');
        }
    }
    //Временная затычка подкгрузок 404.
    public static function errorPage($error_page){
        $error_path = __DIR__ . '/Template/Errors/' . $error_page . '.tpl';
        $general_template = 'general';
        $title = 'Ошибка ' . $error_page;
        if(file_exists($error_path)){
            ob_start();
      	    include_once $error_path;
            $page_data = ob_get_clean();
            include_once __DIR__ . '/Template/' . $general_template . '.tpl';
            exit;
        }
    }


    public function PageJs() {

        if(file_exists(__DIR__ . '/../../public/scripts/' . $this->template_path . '.js')){
            return '/public/scripts/' . $this->template_path . '.js';
        }

    }
}
