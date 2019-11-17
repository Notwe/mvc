<?php
namespace app\Controller;

class IndexController extends AbstractController {

    public function IndexAction () {
        $this->model = $this->bag_models->Index;
        return $this->response->response(['index'=>'index'], $this->page_params);
    }
}