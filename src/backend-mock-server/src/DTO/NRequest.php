<?php

declare(strict_types=1);

namespace DTO;

use Core\TurnoverObject\TurnoverObject;

class NRequest extends TurnoverObject
{
    public function __construct(
        protected string $uri,
        protected string $method,
        protected string $body,
        protected string $queryString,
    ) {}

    public function getQueryString(): string
    {
        return $this->queryString;
    }

    public function setQueryString(string $queryString): NRequest
    {
        $this->queryString = $queryString;
        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): NRequest
    {
        $this->body = $body;
        return $this;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function setUri(string $uri): NRequest
    {
        $this->uri = $uri;
        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): NRequest
    {
        $this->method = $method;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'uri' => $this->getUri(),
            'method' => $this->getMethod(),
            'body' => $this->getBody(),
            'queryString' => $this->getQueryString(),
        ];
    }
}