<?php
// Debug
require 'application/Config/lib/debug.php';
//
use application\Config\router;
use application\Config\lib\db_connect;


spl_autoload_register(function ($class) {
    $path = str_replace('\\', '/', $class.'.php');
    if(file_exists($path)){
        include $path;
    }
});
//use config;
$Roures = new Router;
$db = new DB_connect;
$Roures->start();
