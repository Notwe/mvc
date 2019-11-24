<?php
/**
 * Custom debug  for me 'app/Core/debug.php'
 */
require 'app/Core/debug.php';

/**
 * Autoloader
 */
require 'vendor/Autoloader.php';
/**
 *  Errors Handler
 */
//(new app\Model\ErrorHandler())->error_register();

use app\Core\Dispatcher;
use app\Model\Container\ServiceContainer;

$config =
    [
        __DIR__ . '/app/Config/Services.php',
        __DIR__  . '/app/Config/Routes.php',
    ];
$dispatcher = new Dispatcher(new ServiceContainer($config));

echo $dispatcher->display();

