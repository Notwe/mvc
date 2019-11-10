<?php


namespace app\Model\Response;


class JsonResponse {

    public static function get($data) {
        if (!empty($data)) {
            $data = json_encode($data);
            return $data;
        }
        return false;
    }
}