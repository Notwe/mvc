<?php

namespace app\View;

use app\View\Config\PageTitle;
use app\View\Config\PageParams;

class View
{
    protected $template_folder;
    protected $template_name;
    protected $template_arguments;
    protected $general_template_name;

    public $general_template = 'general';
    public $title            = [];

    //TODO передавать только путь и параметры к шаблону
    //TODO Параметры, передаваемые во View: путь к папке, где лежат шаблоны, параметры для шаблона, наименование шаблона,
    function __construct(string $template_folder, string $template_name, string $general_template_name = 'general', array $template_arguments = [])
    {
        $this->template_folder       = $template_folder;
        $this->template_name         = $template_name;
        $this->template_arguments    = $template_arguments;
        $this->general_template_name = $general_template_name;
    }

    //TODO переименовать на getView()
    public function getTemplate()
    {
        extract($this->template_arguments);
        $template_path = $this->template_folder . '/' . $this->template_name . '.tpl';
        if (file_exists($template_path)) {
            ob_start();
            require $template_path;
            require $this->template_folder . '/' . $this->general_template_name . '.tpl';
            return ob_get_clean();
        } else {
            //error
            $this->errorPage('404');
        }
    }

    //Временная затычка подкгрузок 404.
    //TODO - переделать корректно
    public static function errorPage($error_page)
    {
        $error_path       = __DIR__ . '/Template/Errors/' . $error_page . '.tpl';
        $general_template = 'general';
        $title            = 'Ошибка ' . $error_page;
        if (file_exists($error_path)) {
            ob_start();
            include_once $error_path;
            $page_data = ob_get_clean();
            include_once __DIR__ . '/Template/' . $general_template . '.tpl';
            exit;
        }
    }

    //TODO почистить (удалить)
    public function PageJs()
    {

        if (file_exists(__DIR__ . '/../../public/scripts/' . $this->template_path . '.js')) {
            return '/public/scripts/' . $this->template_path . '.js';
        }

    }
}
