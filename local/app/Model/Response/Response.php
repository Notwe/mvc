<?php

namespace app\Model\Response;

class Response extends ResponseBag {

    public static $statusTexts = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',            // RFC2518
        103 => 'Early Hints',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',          // RFC4918
        208 => 'Already Reported',      // RFC5842
        226 => 'IM Used',               // RFC3229
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary RedirectResponse',
        308 => 'Permanent RedirectResponse',    // RFC7238
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        421 => 'Misdirected Request',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Too Early',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    ];
    private $content;
    private $statusCode;
    public  $headers;
    private $statusText;
    private $version;

    public function __construct ($content = '', $statusCode = 200, $headers = '') {
        $this->setContent($content);
        $this->setStatusCode($statusCode);
        $this->headers = $headers;
        $this->version = '1.0';
        parent::__construct(new CookieResponse, new RedirectResponse, new JsonResponse);
    }

    public function create($content = '', $status = 200, $headers = '') {
        $this->setContent($content);
        $this->setStatusCode($status);
        $this->headers = $headers;
        $this->version = '1.0';
        return $this;
    }
    public function __toString() {
        return
            header($this->headers)."\r\n".
            $this->getContent();
    }

    public function setContent($content) {
        if (null !== $content &&
            !is_string($content) &&
            !is_numeric($content) &&
            !is_callable([$content, '__toString'])) {
            throw new \UnexpectedValueException('The Response content must be a string or object, '. gettype($content) .' given.');
        }

        $this->content = (string) $content;

        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setStatusCode($code, $text = null) {
        $this->statusCode = $code;

        if ($this->statusCode < 100 || $this->statusCode >= 600) {
            throw new \InvalidArgumentException('The HTTP status code '. $code . ' is not valid.');
        }

        if (null === $text) {
            $this->statusText = isset(self::$statusTexts[$code]) ? self::$statusTexts[$code] : 'unknown status';

            return $this;
        }

        if (false === $text) {
            $this->statusText = '';

            return $this;
        }

        $this->statusText = $text;

        return $this;
    }

    public function sendHeaders() {
        if (headers_sent()) {
            return $this;
        }
        if (!empty($this->headers)) {
            foreach ($this->headers as $name => $values) {

                header($name . ': ' . $values);
            }
        }
        header('HTTP/' . $this->version . ' ' . $this->statusCode . ' ' . $this->statusText, true, $this->statusCode);

        return $this;
    }

    public function sendContent() {
        echo $this->content;

        return $this;
    }

    public function send() {
        $this->sendHeaders();
        $this->sendContent();
        return $this;
    }

    public function setCookie(string $name, string $value) {
        $this->cookie::set($name, $value);
        return $this;
    }

    public function clearCookie(string $name) {
        $this->cookie::remove($name);
        return $this;
    }

    public function redirect($url) {
        if (!empty($url)) {
            $this->redirect::set($url);
            exit;
        }
    }

    public function setJson($value) {
        if ($this->json::get($value)) {
            $this->content = $this->json::get($value);
        }
        return $this;
    }

    public function errorPage ($type = 404) {
        $path = 'app/Template/Errors/' . $type . '.tpl';
        if (file_exists($path)) {
            $path = file_get_contents($path);
            $this->create($path, $type);
        }
        return $this;
    }
}