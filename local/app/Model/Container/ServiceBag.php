<?php


namespace app\Model\Container;

use app\Core\Router;
use app\Model\Database\Join;
use app\Model\Database\QueryPrepare;

class ServiceBag{



    public static function preparedConfigServise(){
        return [
            //Request load;
            'Cookie'  => new \app\Model\Request\Cookie($_COOKIE),
            'Server'  =>  new \app\Model\Request\Server($_SERVER),
            'Get'     => new \app\Model\Request\Get($_GET),
            'Post'    =>  new \app\Model\Request\Post($_POST),
            'Request' => function (\app\Model\Container\ServiceContainer $container) {
                return new \app\Model\Request\Request
                (
                    $container->get('Server'),
                    $container->get('Get'),
                    $container->get('Post'),
                    $container->get('Cookie')
                );
            },
            //
            //Response load;
            'Response'         => new \app\Model\Response\Response,
            'View'             => new \app\Model\View,
            'JsonResponse'     => new \app\Model\Response\JsonResponse,
            'RedirectResponse' => new \app\Model\Response\RedirectResponse,
            'ResponseModel'    => function (\app\Model\Container\ServiceContainer $container) {
                return new \app\Model\Response\ResponseModel
                (
                    $container->get('JsonResponse'),
                    $container->get('Response'),
                    $container->get('RedirectResponse'),
                    $container->get('View')
                );
            },
            //

            //Database  load;
            'Jion' => function (\app\Model\Container\ServiceContainer $container) {
                return new \app\Model\Database\Join($container->get('connection_database'));
                },
            'connection_database' => \app\Model\Database\Connection::connect(),
            'QueryPrepare'        => function (\app\Model\Container\ServiceContainer $container) {
                return new QueryPrepare
                (
                    $container->get('connection_database'),
                    $container->get('Jion')
                );
            },
            'Database' => function (\app\Model\Container\ServiceContainer $container) {
                return new \app\Model\Database\Database
                (
                    $container->get('connection_database'),
                    $container->get('QueryPrepare')
                );
            },
            //
            //Controller and Route params load;

            'Routes'     => require __DIR__ . '/../Config/Routes.php',
            'Router'     => function (\app\Model\Container\ServiceContainer $container) {
                return new Router($container->get('Routes'), $container->get('Request')->getURL());
            },
            'Controller' => function (\app\Model\Container\ServiceContainer $container) {
                $controller =  $container->get('Router')->getController();
                $start      = new $controller['controller']($container);
                $action = $controller['action'];
                return $start->$action();
            },
            'Title'      => function (\app\Model\Container\ServiceContainer $container) {
                $title  = new \app\Model\Config\PageTitle;
                $params = $container->get('Router')->getController();
                return $title->get($params['action']);
            },
            //
            //Any Base Model load
            'Model' => function (\app\Model\Container\ServiceContainer $container) {
               return new \app\Model\BaseModel($container);
            },
//            'Account' => function (\app\Model\Container\ServiceContainer $container) {
//                return new \app\Model\AccountModel($container);
//            },
//            'Authorise' => function (\app\Model\Container\ServiceContainer $container) {
//                return new \app\Model\AuthoriseModel($container);
//            },
//            'Register' => function (\app\Model\Container\ServiceContainer $container) {
//                return new \app\Model\RegisterModel($container);
//            },
//            'Main' => function (\app\Model\Container\ServiceContainer $container) {
//                return new \app\Model\MainModel($container);
//            },
            //
        ];
    }
}