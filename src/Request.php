<?php

declare(strict_types=1);

namespace Cheechstack\Http;

class Request {
    protected string $uri;
    protected string $method;
    protected string $ip;
    protected array $queryParams;

    public function __construct() {
        $this->uri = $this->genURI($_SERVER['REQUEST_URI']);
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->queryParams = $this->genQueryParams($_SERVER['QUERY_STRING']);
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
        return explode("?", $requestURI)[0];
    }
}
