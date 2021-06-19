<?php

declare(strict_types=1);

namespace DTO;

use Core\TurnoverObject\TurnoverObject;

class NProxyResponse extends TurnoverObject
{
    public function __construct(
        protected string $responseBody,
        protected int $responseCode,
        protected array $headers
    ) {}

    public function getResponseBody(): string
    {
        return $this->responseBody;
    }

    public function setResponseBody(string $responseBody): NProxyResponse
    {
        $this->responseBody = $responseBody;
        return $this;
    }

    public function getResponseCode(): int
    {
        return $this->responseCode;
    }

    public function setResponseCode(int $responseCode): NProxyResponse
    {
        $this->responseCode = $responseCode;
        return $this;
    }
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers): NProxyResponse
    {
        $this->headers = $headers;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'responseBody' => $this->getResponseBody(),
            'responseCode' => $this->getResponseCode(),
            'headers' => $this->getHeaders(),
        ];
    }
}