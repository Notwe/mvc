<?php


namespace app\Model\Response;


class ResponseModel {

    protected $response;
    protected $jsonResponse;
    protected $redirectResponse;
    protected $view;

    public function __construct(
        JsonResponse $jsonResponse,
        Response $response,
        RedirectResponse $redirectResponse,
        $view )
    {
        $this->response = $response;
        $this->jsonResponse = $jsonResponse;
        $this->redirectResponse = $redirectResponse;
        $this->view = $view;

    }

    public function json($params , int $status_code = 200, array $headers = ['Content-Type'=>'application/json']){
        $this->jsonResponse->setHeaders($headers);
        $this->jsonResponse->setContent($params);
        $this->jsonResponse->setStatusCode($status_code);
        return  $this->jsonResponse;

    }

    public function response(array $template, array $params = [], int $status_code = 200, array $headers = []) {
        $this->response->setHeaders($headers);
        $this->response->setContent($this->view->render($template, $params));
        $this->response->setStatusCode($status_code);

        return $this->response;
    }

    public function redirect ($url) {
        $this->redirectResponse->url($url);
    }

    public function manual ($content = '', $status = 200, $headers = '') {
        $this->response->create($content, $status, $headers);
        return $this->response;
    }

    public function NoExistResponse($template = '', $status_code = 404, $headers = '') {
        $this->response->setHeaders($headers);
        $this->response->setContent($this->view->render($template));
        $this->response->setStatusCode($status_code);
        return $this->response;
    }
}