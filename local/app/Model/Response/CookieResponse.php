<?php


namespace app\Model\Response;


class CookieResponse {
     public static function set(string $name, string $value = null, $expire = 100500, $path = '/') {
         if (empty($name)) {
             throw new \InvalidArgumentException('The cookie name cannot be empty.');
         }
         setcookie($name, $value, time() + $expire, $path);
     }

    public static function remove(string $name, $path = '/') {
        if (empty($name)) {
            throw new \InvalidArgumentException('The cookie name cannot be empty.');
        }
        setcookie($name, '', time() -100500, $path);
    }
}