<?php


namespace app\Model\Response;


class ResponseBag {
    public $cookie;
    public $redirect;
    public $json;



    public function __construct (CookieResponse $cookie, RedirectResponse $redirect, JsonResponse $json) {

        $this->cookie   = $cookie;
        $this->redirect = $redirect;
        $this->json     = $json;
    }

}