<?php

declare(strict_types=1);

namespace CodeTry\MockServerSDK\Dto\Request;

use CodeTry\MockServerSDK\Factory\SerializerFactory;
use CodeTry\MockServerSDK\Request;
use JMS\Serializer\Annotation as Serializer;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class AddNSettingsRequest implements Request
{
    private const BASE_PATH = 'api/v1/nspace/';
    private const PATH = '/settings/add';

    /**
     * @Serializer\Exclude
     */
    private string $nSpaceId;

    private string $body;
    private string $uri;
    private string $method;
    private int $code;
    private array $headers;
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("queryString")
     */
    private string $queryString;

    public function __construct(
        string $nSpaceId,
        string $body,
        string $uri,
        string $method,
        int $code,
        array $headers,
        string $queryString
    ) {
        $this->nSpaceId = $nSpaceId;
        $this->body = $body;
        $this->uri = $uri;
        $this->method = $method;
        $this->code = $code;
        $this->headers = $headers;
        $this->queryString = $queryString;
    }

    public function getNSpaceId(): string
    {
        return $this->nSpaceId;
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getPath(): string
    {
        return self::BASE_PATH . $this->getNSpaceId() . self::PATH;
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
