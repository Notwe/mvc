<?php
// Debug
require 'app/Config/lib/debug.php';
require 'app/Config/lib/Autoloader.php';
(new app\Config\lib\Errors\ErrorHandler())->error_register();
//
use app\Config\Core\Dispatcher;
use app\Config\Core\Request;
//
$dispatcher = new Dispatcher;
$request = new Request;
