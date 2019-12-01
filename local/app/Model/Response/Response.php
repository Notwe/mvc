<?php

namespace app\Model\Response;

class Response extends AbstractResponse {


    public function customResponse($content = '', $status = 200, $headers = '', $version = '1.1') {
        $this->setContent($content);
        $this->setStatusCode($status);
        $this->headers = $headers;
        $this->version = $version;
    }
    public function __toString() {
        $this->sendHeaders();
        return $this->content;
    }
}