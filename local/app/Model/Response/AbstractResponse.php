<?php


namespace app\Model\Response;


abstract class AbstractResponse {

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

    protected $headers;
    protected $content;
    protected $status_code;
    protected $status_text;
    protected $version = '1.1';

    abstract public function __toString();


    public function sendHeaders() {
        if (!empty($this->headers)) {
            foreach ($this->headers as $name => $values) {
                header($name . ': ' . $values);
            }
        }
        header('HTTP/' . $this->version . ' ' . $this->status_code . ' ' . $this->status_text, true, $this->status_code);
    }



    public function setHeaders($headers) {

        $this->headers = $headers;
    }


    public function getContent() {
        return $this->content;
    }


    public function setContent($content) {
        $this->content = $content;
    }


    public function getStatusCode() {
        return $this->status_code;
    }



    public function setStatusCode($status_code = 200, $text = null) {
        $this->status_code = $status_code;

        if ($this->status_code < 100 || $this->status_code >= 600) {
            throw new \InvalidArgumentException('The HTTP status code '. $status_code . ' is not valid.');
        }

        if (null === $text) {
             $this->status_text = isset(self::$statusTexts[$status_code]) ? self::$statusTexts[$status_code] : 'unknown status';
             return $this;

        }

        if (false === $text) {
            $this->status_text = '';
            return $this;

        }

        $this->status_text = $text;
        return $this;
    }

    public function prepearHeaders() {}
    
}