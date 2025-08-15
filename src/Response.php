<?php

declare(strict_types = 1);

namespace Cheechstack\Http;

class Response {
    protected int $statusCode;
    protected array $headers;
    protected string $body;

    protected function __construct(
        int $statusCode,
        array $headers,
        string $body
    ) {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        $this->body = $body;
    }

    public static function view(
        string $viewTemplate
    ) : self {
        // find the view template
        //$view = View::locate($viewTemplate);
        //$body = $view->render();

        // build the headers for a html text response
        $headers = array();
        $headers['Content-Type'] = 'text/html';
        $headers['Content-Length'] = strlen($viewTemplate);

        return new self(200, $headers, $body);
    }

    public function getHeaders(): array {
        return $this->headers;
    }

    public function getBody(): string {
        return $this->body;
    }

    public function setStatus(int $statusCode): void {
        $this->statusCode = $statusCode;
    }

    public function setHeaders(array $headers, bool $replace = false): void {
        if ($replace) {
            $this->headers = $headers;
        } else {
            $this->headers[] = $headers;
        }
    }

    public function setBody(string $body): void {
        $this->body = $body;
    }
}