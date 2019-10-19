<?php
// Debug
require 'app/Config/lib/debug.php';
require 'app/Config/lib/Autoloader.php';
(new app\Config\lib\Errors\ErrorHandler())->error_register();
//
use app\Config\Router;
use app\Config\lib\Database;
//
$Roures = new Router;
$Roures->start();
