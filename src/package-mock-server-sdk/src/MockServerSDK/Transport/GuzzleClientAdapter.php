<?php

declare(strict_types=1);

namespace CodeTry\MockServerSDK\Transport;

use GuzzleHttp\RequestOptions;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GuzzleClientAdapter implements ClientInterface
{
    private \GuzzleHttp\ClientInterface $httpClient;
    private ?string $proxy;

    public function __construct(\GuzzleHttp\ClientInterface $httpClient, string $proxy = null)
    {
        $this->httpClient = $httpClient;
        $this->proxy = $proxy;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $options = [];
        if ($this->proxy) {
            $options[RequestOptions::PROXY] = $this->proxy;
        }

        return $this->httpClient->send($request, $options);
    }
}
