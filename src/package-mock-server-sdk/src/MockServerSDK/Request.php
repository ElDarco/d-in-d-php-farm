<?php

declare(strict_types=1);

namespace CodeTry\MockServerSDK;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Interface Request.
 */
interface Request
{
    public function getMethod(): string;

    public function getPath(): string;

    public function getBody(): string;

    public function toPSRRequest(
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        string $baseUrl
    ): RequestInterface;
}
