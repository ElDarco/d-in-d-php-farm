<?php

declare(strict_types=1);

namespace CodeTry\MockServerSDK\Factory;

use CodeTry\MockServerSDK\Transport\GuzzleClientAdapter;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Client\ClientInterface;

class GuzzleClientFactory
{
    public static function createWith(string $proxy): ClientInterface
    {
        return new GuzzleClientAdapter(new GuzzleClient(), $proxy);
    }
}
