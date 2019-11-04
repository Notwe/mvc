<?php

namespace app\Component\DependencyInjection;



//TODO удалить, и вынести в файл конфигурации, который будет загружатся в сервис-контейнер
class DefaultComponet{
    public $_classes;

    public function getDefaultComponent(){
        $this->_classes = [
            'DatabaseConfig' => 'app\Component\Database\DatabaseConfig',
            'Connection'     => 'app\Component\Database\Connection',
            'QueryConfig'    => 'app\Component\Database\QueryConfig',
            'Database'       => 'app\Component\Database',
            'Cookie'         => 'app\Component\Request\Cookie',
            'Get'            => 'app\Component\Request\Get',
            'Post'           => 'app\Component\Request\Post',
            'Server'         => 'app\Component\Request\Server',
            'Request'        => 'app\Component\Request',
            'Routing'        => 'app\Component\Routing',
            'Router'         => 'app\Core\Router',

        ];
        return $this->_classes;
    }
}
