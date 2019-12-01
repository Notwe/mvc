<?php
namespace app\Controller;

class IndexController extends AbstractController {

    public function IndexAction () {
        $this->container->get('IndexModel');

        return $this->response->response (
            ['index'=>'index'],
            ['title' => 'Главная']
        );
    }
}