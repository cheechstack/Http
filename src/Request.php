<?php

declare(strict_types=1);

namespace Cheechstack\Http;

class Request {
    protected string $uri;
    protected string $method;
    protected string $ip;
    protected array $queryParams;

    private function __construct($uri, $method, $ip, $queryString) {
        $this->uri = $this->genURI($uri);
        $this->method = $method;
        $this->ip = $ip;
        $this->queryParams = $this->genQueryParams($queryString);
    }

    public function getRequestURI() : string {
        return $this->uri;
    }

    public function getRequestMethod() : string {
        return $this->method;
    }

    public function getUserIP() : string {
        return $this->ip;
    }

    public function getQueryParameters() : array {
        return $this->queryParams;
    }

    /** Generate an associative array of query parameters from a provided
    * string.
    *
    * @param string $paramString    The url formatted query parameter string.
    * @return array
    */
    private function genQueryParams(string $paramString) : array {
        $paramString = trim($paramString);
        $params = [];

        $lenParamString = strlen($paramString);
        if ($lenParamString > 0) {
            // split the parameter string into a list of values
            $tmp = explode('&', $paramString);

            // split each tmp value into its component parts and push them to the
            // parms list.
            foreach ($tmp as $token) {
                $split = explode('=', $token);
                $params[$split[0]] = $split[1] ?? "_blank";
            }
        }

        return $params;
    }

    private function genURI(string $requestURI) : string {
        // https://www.example.com/test/case?equals=me
        $pre = explode("?", $requestURI)[0];
        // https://www.example.com/test/case 
        $split = explode(".", $pre);
        $last = $split[count($split) - 1];
        // com/test/case
        $elements = explode("/", $last);
        array_shift($elements);
        // [test, case]
        return implode("/", $elements);
    }

    public static function createFromServer() : self {
        $uri = $_SERVER['REQUEST_URI'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $method = $_SERVER['REQUEST_METHOD'];
        $queryString = $_SERVER['QUERY_STRING'];

        return new self($uri, $method, $ip, $queryString);
    }

    public static function createForTest(
        string $url,
        string $ip,
        string $method,
        string $queryString
    ) : self {
        return new self($uri, $method, $ip, $queryString); 
    }
}
