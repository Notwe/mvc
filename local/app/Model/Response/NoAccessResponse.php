<?php


namespace app\Model\Response;


class NoAccessResponse extends AbstractResponse {

    public function __toString () {
        $this->setStatusCode(403);
        header('HTTP/1.1  403' . $this->status_text, true, 403);
        return $this->status_text;
    }
}