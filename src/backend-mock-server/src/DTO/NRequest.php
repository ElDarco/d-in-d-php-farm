<?php

declare(strict_types=1);

namespace DTO;

use Core\TurnoverObject\TurnoverObject;

class NRequest extends TurnoverObject
{
    public function __construct(
        protected string $id,
        protected string $uri,
        protected string $method,
        protected string $body,
        protected string $queryString,
        protected \DateTimeInterface|string $createdAt,
        protected ?NProxyResponse $proxyResponse = null,
        protected array $headers = []
    ) {
        $this->setCreatedAt($this->createdAt);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): NRequest
    {
        $this->id = $id;
        return $this;
    }

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

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface|string $createdAt): NRequest
    {
        if (is_string($createdAt)) {
            $createdAt = new \DateTimeImmutable($createdAt);
        }
        $this->createdAt = $createdAt;
        return $this;
    }

    public function addNProxyResponse(NProxyResponse $proxyResponse): NRequest
    {
        $this->proxyResponse = $proxyResponse;
        return $this;
    }

    /**
     * @return NProxyResponse|null
     */
    public function getProxyResponse(): ?NProxyResponse
    {
        return $this->proxyResponse;
    }

    /**
     * @param NProxyResponse|null $proxyResponse
     * @return NRequest
     */
    public function setProxyResponse(?NProxyResponse $proxyResponse): NRequest
    {
        $this->proxyResponse = $proxyResponse;
        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers): NRequest
    {
        $this->headers = $headers;
        return $this;
    }


    public function toArray(): array
    {
        $proxyResponse = [];
        if ($this->proxyResponse) {
            $proxyResponse = $this->proxyResponse->toArray();
        }
        return [
            'id' => $this->getId(),
            'uri' => $this->getUri(),
            'method' => $this->getMethod(),
            'body' => $this->getBody(),
            'queryString' => $this->getQueryString(),
            'createdAt' => $this->getCreatedAt()->format('Y-m-d h:i:s'),
            'proxyResponse' => $proxyResponse,
            'headers' => $this->getHeaders(),
        ];
    }
}