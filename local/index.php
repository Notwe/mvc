<?php
// Debug
require 'app/Core/debug.php';
require 'app/vendor/Autoloader.php';
(new app\Component\ErrorHandler())->error_register();
//
use app\Core\Dispatcher;
use app\Component\DependencyInjection\Container;
//
$dispatcher = new Dispatcher(new Container);
// $request = new Request;
