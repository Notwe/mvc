<?php
// Debug
require 'app/Core/debug.php';
require 'app/vendor/Autoloader.php';
(new app\Model\ErrorHandler())->error_register();
//
use app\Core\Dispatcher;
use app\Model\Container\ServiceContainer;
//
$dispatcher = new Dispatcher(new ServiceContainer);

//TODO реализовать подобный метод для возврата Response|RedirectResponse|JsonResponse
echo $dispatcher->display();

