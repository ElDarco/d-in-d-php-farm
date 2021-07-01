<?php

declare(strict_types=1);

namespace CodeTry\MockServerSDK\Factory;

use CodeTry\MockServerSDK\Client;
use CodeTry\MockServerSDK\ClientInterface;
use Psr\Http\Client\ClientInterface as PSRClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class MockServerSDKFactory
{
    public static function createWith(
        PSRClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        string $baseUrl
    ): ClientInterface {
        return new Client($httpClient, $requestFactory, $streamFactory, $baseUrl);
    }
}
