<?php
namespace app\Config\lib\Errors;

class ErrorHandler{


    public function error_register(){
        set_error_handler([$this, 'errors']);
        register_shutdown_function([$this, 'fatal_errors']);
        //set_exception_handler
    }

    public function errors($error_level, $error_string, $error_file, $error_line){
        $this->error_handling($error_level, $error_string, $error_file, $error_line);
        return true;
    }


    public function fatal_errors(){
        if($error = error_get_last() AND $error['type'] & ( E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)){
            ob_end_clean();
            $this->error_handling($error['type'], $error['message'], $error['file'], $error['line']);
        }
    }


    public function error_handling ($error_number, $error_string, $error_file, $error_line){
        $errors = $this->error_type($error_number);
        if(stristr($error_string, 'mysqli') == true) {
            $log_file = __DIR__ . '/Log/ErrorsSQL/'. date("d.m.y") . '.log';
        }else{
            $log_file = __DIR__ . '/Log/ErrorsSite/'. date("d.m.y") . '.log';
        }
        $this->log_write($errors,$error_string, $error_file, $error_line,$log_file);

        //временно
        $this->show_error($errors,$error_string, $error_file, $error_line);

    }

    public function log_write($errors,$error_string, $error_file, $error_line, $path){
        $log_message = date("H:i:s") .' '. $errors .' '. $error_string .' '. $error_file .' line '. $error_line;
        $file = fwrite(fopen($path, 'a'), $log_message . "\r\n");
    }

    public function error_type($type){

        switch($type) {
            case E_ERROR: // 1 //
                return 'ERROR - Фатальная ошибка';
            case E_WARNING: // 2 //
                return 'WARNING - Предупреждение';
            case E_PARSE: // 4 //
                return 'PARSE - Ошибка';
            case E_NOTICE: // 8 //
                return 'NOTICE - Уведомление';
            case E_CORE_ERROR: // 16 //
                return 'CORE_ERROR - Фатальная ошибка';
            case E_CORE_WARNING: // 32 //
                return 'CORE_WARNING - Предупреждение';
            case E_COMPILE_ERROR: // 64 //
                return 'COMPILE_ERROR - Фатальная ошибка';
            case E_COMPILE_WARNING: // 128 //
                return 'COMPILE_WARNING - Предупреждение';
            case E_USER_ERROR: // 256 //
                return 'USER_ERROR - Ошибка';
            case E_USER_WARNING: // 512 //
                return 'USER_WARNING - Предупреждение';
            case E_USER_NOTICE: // 1024 //
                return 'USER_NOTICE - Уведомление';
            case E_STRICT: // 2048 //
                return 'STRICT';
            case E_RECOVERABLE_ERROR: // 4096 //
                return 'RECOVERABLE_ERROR - Фатальная ошибка';
            case E_DEPRECATED: // 8192 //
                return 'DEPRECATED - Уведомление';
            case E_USER_DEPRECATED: // 16384 //
                return 'USER_DEPRECATED - Уведомление';
        }
        return $type;
    }


//времянка
    public function show_error($error_type, $error_string, $error_file, $error_line){

        echo
        '<p><b>' . $error_type
        . '</b></p><p>' . $error_string
        . 'Файл: ' .  $error_file
        . ' Line: ' .  $error_line .'</p>';

    }

}
