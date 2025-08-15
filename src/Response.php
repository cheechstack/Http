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

        // tmp body value
        $body = <<<EOT
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Temp Title</title>
        </head>
        <body>
            <h1>Hello World! This is Cheech's "Response" class.</h1>
        </body>
        </html>
        EOT;


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