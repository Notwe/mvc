<?php

namespace app\Model;

class View {
    public static function render(array $path, array $template_arguments = [], $general_template_name = 'general') {

        $default_template_path =  'app/Template';
        extract($template_arguments);
        $template_path = $default_template_path .'/' . $path['controller'] . '/' . $path['action'] . '.tpl';
        if (file_exists($template_path)) {
            ob_start();
            $page = file_get_contents($template_path);
            require $default_template_path . '/' . $general_template_name . '.tpl';
            $result = ob_get_contents();
            ob_end_clean();
            return $result;
        }
        return false;
    }

}
