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

        if(!is_null($this->content) && is_string($this->content)) {
            return $this->content;
        }

        return $this->content;
    }
}