<?php


namespace app\Model\Response;


class JsonResponse extends AbstractResponse {
    public function __toString() {
        $this->sendJsonHeader();

        if(!empty($this->content) && is_array($this->content)) {
            return json_encode($this->content);
        }

        return $this->content;
    }


    public function sendJsonHeader() {
        $this->sendHeaders();
    }
}