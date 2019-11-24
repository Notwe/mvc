<?php


namespace app\Model\Response;


class NotFoundResponse extends AbstractResponse {

    public function __toString () {
        $this->setStatusCode(404);
        header('HTTP/1.1  404' . $this->status_text, true, 404);
        return $this->status_text;
    }
}