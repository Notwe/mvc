<?php


namespace app\Model\Request;

/**
 * @property int|array argc
 * @property int|array argv
 * @property string QUERY_STRING
 * @property string REQUEST_URI
 * @property string REQUEST_METHOD
 * @property string DOCUMENT_ROOT
 * @property string PATH_TRANSLATED
 * @property string PATH_INFO
 * @property string SERVER_NAME
 */
class Server{
    protected $server;


    public function __construct (array $server) {
        $this->server = $server;
    }

    public function __get(string $name) {
        if(array_key_exists($name, $this->server)) {
            return $this->server[$name];
        }
        throw new \Exception('No Server value found with the name "' . $name . '"');
    }

}