<?php
namespace app\Controller;

class IndexController extends AbstractController {

    public function IndexAction () {
        $this->model      = $this->container->get('IndexModel');
        $this->page_title = 'Главная';
        return $this->response->response (
            ['index'=>'index'],
            ['title' => $this->page_title]
        );
    }
}