<?php
namespace app\Controller;

class IndexController extends AbstractController {

    public function IndexAction () {
        $this->getModel('Index');
        $this->response->create($this->view::render($this->path,['title'=> $this->page_title]));
    }
}