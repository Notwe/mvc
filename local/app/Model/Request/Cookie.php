<?php


namespace app\Model\Request;


class Cookie extends AbstractParameterBag {

    public static function setCookies(string $name, string $value = null, $expire = 100500, $path = '/') {
        if (empty($name)) {
            throw new \InvalidArgumentException('The cookie name cannot be empty.');
        }
        setcookie($name, $value, time() + $expire, $path);
    }

    public static function removeCookies(string $name, $path = '/') {
        if (empty($name)) {
            throw new \InvalidArgumentException('The cookie name cannot be empty.');
        }
        setcookie($name, '', time() -100500, $path);
    }

}