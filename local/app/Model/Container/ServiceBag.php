<?php


namespace app\Model\Container;

use app\Core\Router;
use app\Model\Database\QueryPrepare;

class ServiceBag{



    public static function preparedConfigServise(){
        return [
            'Routes' => \app\Model\Config\Routes::get(),
            'Router' => function (\app\Model\Container\ServiceContainer $container) {
                return new Router($container->get('Routes'));
            },
            'CookieRequest' => new \app\Model\Request\Cookie($_COOKIE),
            'Server' =>  new \app\Model\Request\Server($_SERVER),
            'GetRequest' => new \app\Model\Request\Get($_GET),
            'PostRequest' =>  new \app\Model\Request\Post($_POST),
            'Request' => function (\app\Model\Container\ServiceContainer $container) {
                return new \app\Model\Request\Request(
                    $container->get('Server'),
                    $container->get('GetRequest'),
                    $container->get('PostRequest'),
                    $container->get('CookieRequest')
                );
            },
            'Response' => new \app\Model\Response\Response,
            'connection_database' => \app\Model\Database\Connection::connect(),
            'QueryPrepare' => function (\app\Model\Container\ServiceContainer $container) {
                return new QueryPrepare($container->get('connection_database'));
            },
            'Database' => function (\app\Model\Container\ServiceContainer $container) {
                return new \app\Model\Database\Database(
                    $container->get('connection_database'),
                    $container->get('QueryPrepare')
                );
            },
            'Model' => new \app\Model\BaseModel,
            'View' => new \app\Model\View,
            'Title' => new \app\Model\Config\PageTitle,
        ];
    }
}