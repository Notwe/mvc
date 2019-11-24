<?php


namespace app\Model\Response;


class NoAccessResponse extends AbstractResponse {

    public function __toString () {
        $this->sendHeaders();
        return $this->status_text;
    }
}