<?php

declare(strict_types=1);

namespace Factory;

use DTO\NRequest;
use DTO\NSettings;
use DTO\NSpace;
use Ramsey\Uuid\Uuid;

class DtoFactory
{
    public static function createNSpace(string $name = ''): \DTO\NSpace
    {
        if (!$name) {
            $name = 'somename_' . time();
        }
        return new NSpace((Uuid::uuid4())->toString(), $name, [], []);
    }

    public static function createNRequest(
        string $uri,
        string $method,
        string $body,
        string $queryString,
        \DateTimeInterface|string $createdAt
    ): \DTO\NRequest {
        return new NRequest(
            (Uuid::uuid4())->toString(),
            $uri,
            $method,
            $body,
            $queryString,
            $createdAt
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
}