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
            } else {
                return false;
            }
        }
        return $this->post;
    }

    public function getGet(string $key = null) {
        if ($key !== null) {
            if ($this->get->get($key) !== false) {
                return $this->get->get($key);
            } else {
                return false;
            }
        }
        return $this->get;
    }
    // end
    public function getMethod () {
        return $this->method;
    }

    public function getUrl () {
        return $this->url;
    }

    public function getQueryString ()
    {
        return $this->query_string;
    }

    protected function initServer(Server $server) {
        $this->url          = $server->REQUEST_URI;
        $this->query_string = $server->QUERY_STRING;
        $this->method       = $server->REQUEST_METHOD;

    }

}