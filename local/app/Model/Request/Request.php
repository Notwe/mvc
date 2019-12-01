<?php


namespace app\Model\Request;


class Request{

    protected $server;
    protected $get;
    protected $post;
    protected $cookie;

    protected $url;
    protected $method;
    protected $query_string;

    public function __construct (Server $server, Get $get, Post $post, Cookie $cookie) {
        $this->initServer($server);
        $this->get    = $get;
        $this->post   = $post;
        $this->cookie = $cookie;
    }

    public function get (string $name ) {
        if($this->post->get($name) !== false) {
            return $this->post->get($name);
        }

        if($this->get->get($name) !== false) {
            return $this->get->get($name);
        }
        return false;
    }

    public function getCookie (string $name) {
        if($this->cookie->get($name) !== false) {
            return $this->cookie->get($name);
        }
        return false;
    }

    //вариант второй
    public function getPost(string $key = null) {
        if ($key !== null) {
            if ($this->post->get($key) !== false) {
                return $this->post->get($key);
            }
        }
        return $this->post->getAllPost();
    }

    public function getGet(string $key = null) {
        if ($key !== null) {
            if ($this->get->get($key) !== false) {
                return $this->get->get($key);
            } else {
                return false;
            }
        }
        return $this->get->getAllGet();
    }
    // end
    public function getMethod () {
        return $this->method;
    }

    public function getUrl () {
        return $this->url;
    }

    public function getQueryString () {
        return $this->query_string;
    }

    public function setCookie(array $params, $expire = 100500) {
        foreach ($params as $name => $value) {
            $this->cookie::setCookies($name, $value, $expire);
        }
        return true;
    }

    public function clearCookie(string $name) {
        $this->cookie::removeCookies($name);
        return true;
    }

    protected function initServer(Server $server) {
        $this->url          = $server->REQUEST_URI;
        $this->query_string = $server->QUERY_STRING;
        $this->method       = $server->REQUEST_METHOD;

    }

}