<?php

declare(strict_types=1);

namespace Factory;

use DTO\NProxyResponse;
use DTO\NRequest;
use DTO\NSettings;
use DTO\NSpace;
use Ramsey\Uuid\Uuid;

class DtoFactory
{
    public static function createNSpace(string $name = '', bool $useProxy = false, string $proxyToUrl = ''): \DTO\NSpace
    {
        if (!$name) {
            $name = 'somename_' . time();
        }
        return new NSpace((Uuid::uuid4())->toString(), $name, [], [], $useProxy, $proxyToUrl);
    }

    public static function createNRequest(
        string $uri,
        string $method,
        string $body,
        string $queryString,
        \DateTimeInterface|string $createdAt,
        ?NProxyResponse $proxyResponse = null,
    ): \DTO\NRequest {
        return new NRequest(
            (Uuid::uuid4())->toString(),
            $uri,
            $method,
            $body,
            $queryString,
            $createdAt,
            $proxyResponse
        );
    }

    public static function createNSettings(
        string $uri,
        string $method,
        string $responseBody,
        int $responseCode,
        string $queryString,
        array $headers
    ): \DTO\NSettings {
        return new NSettings(
            (Uuid::uuid4())->toString(),
            $uri, $method,
            $responseBody,
            $responseCode,
            $queryString,
            $headers
        );
    }

    public static function createNProxyResponse(
        string $responseBody,
        int $responseCode,
        array $headers
    ) : NProxyResponse {
        return new NProxyResponse($responseBody, $responseCode, $headers);
    }
}