<?php


namespace app\Model\Response;


class JsonResponse extends AbstractResponse {
    public function __toString() {
        $this->setHeaders(['Content-Type'=>'application/json']);
        $this->sendHeaders();

        if(!empty($this->content) && is_array($this->content)) {
            return json_encode($this->content);
        }
        return false;
    }
}