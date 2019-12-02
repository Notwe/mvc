<?php
     return   [
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
            'NoAccessResponse' => new \app\Model\Response\NoAccessResponse,
            'NotFoundResponse' => new \app\Model\Response\NotFoundResponse,
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
                    $container->get('View'),
                    $container->get('NoAccessResponse'),
                    $container->get('NotFoundResponse')

                );
            },
            //

            //Database  load;
            'Jion' => function (\app\Model\Container\ServiceContainer $container) {
                return new \app\Model\Database\Join($container->get('connection_database'));
            },
            'connection_database' => \app\Model\Database\Connection::connect(),
            'QueryPrepare'        => function (\app\Model\Container\ServiceContainer $container) {
                return new \app\Model\Database\QueryPrepare
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
            'Router'     => function (\app\Model\Container\ServiceContainer $container) {
                return new app\Core\Router($container->get('Routes'), $container->get('Request')->getURL());
            },
            'Controller' => function (\app\Model\Container\ServiceContainer $container) {
                $controller =  $container->get('Router')->getController();
                $start      = new $controller['controller']($container);
                $action     = $controller['action'];
                return $start->$action();
            },
            //
            //Any Model load
            'AccountModel' => function (\app\Model\Container\ServiceContainer $container) {
                return new \app\Model\AccountModel(
                    $container->get('Database'),
                    $container->get('Request')
                );
            },
            'AuthorizeModel' => function (\app\Model\Container\ServiceContainer $container) {
                return new \app\Model\AuthorizeModel(
                    $container->get('Request'),
                    $container->get('ResponseModel'),
                    $container->get('Database'),
                    $container->get('AccountModel')
                );
            },
            'RegisterModel' => function (\app\Model\Container\ServiceContainer $container) {
                return new \app\Model\RegisterModel(
                    $container->get('Request'),
                    $container->get('ResponseModel'),
                    $container->get('Database'),
                    $container->get('AccountModel')
                );
            },
            'MainModel' => function (\app\Model\Container\ServiceContainer $container) {
                return new \app\Model\MainModel(
                    $container->get('Request'),
                    $container->get('ResponseModel'),
                    $container->get('Database'),
                    $container->get('AccountModel')
                );
            },
            'IndexModel' => function (\app\Model\Container\ServiceContainer $container) {
                return new \app\Model\IndexModel(
                    $container->get('Request'),
                    $container->get('ResponseModel'),
                    $container->get('Database'),
                    $container->get('AccountModel')
                );
            },
            'ViewOptions' =>  new app\Model\Chat\ViewOptions,

            'AjaxValidation' => function (\app\Model\Container\ServiceContainer $container) {
                return new \app\Model\AjaxValidation(
                    $container->get('AuthorizeModel'),
                    $container->get('RegisterModel'),
                    $container->get('ChatModel')
                );
            },
            /**
             * Chat models app/Model/Chat
             */
            'MessageChatModel'        => function (\app\Model\Container\ServiceContainer $container) {
                return new \app\Model\Chat\Message($container->get('Database'));
                },

            'ChatModel' => function (\app\Model\Container\ServiceContainer $container) {
                return new \app\Model\Chat\ChatModel(
                     $container->get('Request'),
                     $container->get('ResponseModel'),
                     $container->get('Database'),
                     $container->get('AccountModel'),
                     $container->get('MessageChatModel')
                 );
         },

        ];