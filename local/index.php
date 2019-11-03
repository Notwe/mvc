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

//TODO реализовать подобный метод для возврата Response|RedirectResponse|JsonResponse
echo $dispatcher->display();
// $request = new Request;
