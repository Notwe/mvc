<?php
spl_autoload_register(function ($class) {
    $path = str_replace('\\', '/', $class.'.php');
    //var_dump($path);
    if(file_exists($path)){
        include $path;
    }
});
