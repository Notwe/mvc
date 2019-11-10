<?php


namespace app\Model\Response;


class RedirectResponse {

    public static function set($url){
        if (!empty($url)) {
            header('Location:' . $url, true, 302);
            exit;
        } else {
            return false;
        }
    }

}