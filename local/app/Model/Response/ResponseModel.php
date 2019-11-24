<?php


namespace app\Model\Response;


use app\Model\View;

class ResponseModel {

    protected $response;
    protected $jsonResponse;
    protected $redirectResponse;
    protected $view;
    protected $noAccess;
    protected $notFound;

    public function __construct(
        JsonResponse     $jsonResponse,
        Response         $response,
        RedirectResponse $redirectResponse,
        View             $view,
        NoAccessResponse $noAccess,
        NotFoundResponse $notFound
        )
    {
        $this->response         = $response;
        $this->jsonResponse     = $jsonResponse;
        $this->redirectResponse = $redirectResponse;
        $this->view             = $view;
        $this->notFound         = $notFound;
        $this->noAccess         = $noAccess;

    }

    public function json($params , int $status_code = 200){
        $this->jsonResponse->setContent($params);
        $this->jsonResponse->setStatusCode($status_code);
        return  $this->jsonResponse;

    }

    public function response(array $template, array $params = [], int $status_code = 200) {
        $this->response->setContent($this->view->render($template, $params));
        $this->response->setStatusCode($status_code);

        return $this->response;
    }

    public function redirect ($url) {
        $this->redirectResponse->setUrl($url);
        return $this->redirectResponse;
    }

    public function manual ($content = '', $status = 200, $headers = '') {
        $this->response->create($content, $status, $headers);
        return $this->response;
    }

///TODO TESTTTTTTTT ONLY TEST вызов кастомной страницы
    public function test_errors_response (int $code) {
        $this->response->setContent($this->view->render(['Errors' => $code], ['title' => $code]));
        $this->response->setStatusCode($code);
        return $this->response;
    }
}