<?php

declare(strict_types=1);

namespace DTO;

use Core\TurnoverObject\TurnoverObject;

class NSettings extends TurnoverObject
{
    public function __construct(
        protected string $id,
        protected string $uri,
        protected string $method,
        protected string $responseBody,
        protected int $responseCode
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): NSettings
    {
        $this->id = $id;
        return $this;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function setUri(string $uri): NSettings
    {
        $this->uri = $uri;
        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): NSettings
    {
        $this->method = $method;
        return $this;
    }

    public function getResponseBody(): string
    {
        return $this->responseBody;
    }

    public function setResponseBody(string $responseBody): NSettings
    {
        $this->responseBody = $responseBody;
        return $this;
    }

    public function getResponseCode(): int
    {
        return $this->responseCode;
    }

    public function setResponseCode(int $responseCode): NSettings
    {
        $this->responseCode = $responseCode;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'uri' => $this->getUri(),
            'method' => $this->getMethod(),
            'responseBody' => $this->getResponseBody(),
            'responseCode' => $this->getResponseCode(),
        ];
    }
}