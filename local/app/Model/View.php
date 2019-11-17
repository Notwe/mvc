<?php

namespace app\Model;

class View {
    public function render( array $path, array $template_arguments = [], $general_template_name = 'general') {
        $template = [];
        foreach ($path as $key => $value){
            $template['path'] = $key;
            $template['action'] = $value;

        }
        $default_template_path =  'app/Template';
        extract($template_arguments);
        $template_path = $default_template_path .'/' . $template['path'] . '/' . $template['action'] . '.tpl';
        if (file_exists($template_path)) {
            ob_start();
            require $template_path;
            $page = ob_get_clean();
            ob_start();
            require $default_template_path . '/' . $general_template_name . '.tpl';
            $result = ob_get_contents();
            ob_end_clean();
            return $result;
        }
        return false;
    }

}
