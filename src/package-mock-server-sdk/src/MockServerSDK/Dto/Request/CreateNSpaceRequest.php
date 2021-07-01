<?php

declare(strict_types=1);

namespace CodeTry\MockServerSDK\Dto\Request;

use CodeTry\MockServerSDK\Factory\SerializerFactory;
use CodeTry\MockServerSDK\Request;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class CreateNSpaceRequest implements Request
{
    private const PATH = 'api/v1/nspace/';

    private string $name;
    private bool $useProxy;
    private string $proxyToUrl;

    public function __construct(string $name, bool $useProxy, string $proxyToUrl)
    {
        $this->name = $name;
        $this->useProxy = $useProxy;
        $this->proxyToUrl = $proxyToUrl;
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getPath(): string
    {
        return self::PATH;
    }

    public function getBody(): string
    {
        return (new SerializerFactory())
            ->createSerializer()
            ->serialize($this, 'json', null, self::class);
    }

    public function toPSRRequest(
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        string $baseUrl
    ): RequestInterface {
        return $requestFactory
            ->createRequest($this->getMethod(), $baseUrl . $this->getPath())
            ->withBody($streamFactory->createStream($this->getBody()));
    }
}
