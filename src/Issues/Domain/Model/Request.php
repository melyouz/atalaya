<?php

declare(strict_types=1);

namespace App\Issues\Domain\Model;

class Request
{
    private string $method;
    private string $url;
    private array $headers = [];

    private function __construct(RequestMethod $method, RequestUrl $url)
    {
        $this->method = $method->value();
        $this->url = $url->value();
    }

    public static function create(RequestMethod $method, RequestUrl $url, array $headers = [])
    {
        $request =  new self($method, $url);
        $request->addHeadersFromArray($headers);

        return $request;
    }

    public function addHeadersFromArray(array $headers)
    {
        if (empty($headers)) {
            return;
        }

        $this->headers = array_merge($this->headers, $headers);
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::fromString($this->method);
    }

    public function getUrl(): RequestUrl
    {
        return RequestUrl::fromString($this->url);
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}
