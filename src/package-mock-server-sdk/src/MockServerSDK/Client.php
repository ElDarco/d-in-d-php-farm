<?php

declare(strict_types=1);

namespace CodeTry\MockServerSDK;

use CodeTry\MockServerSDK\Dto\Request\AddNSettingsRequest;
use CodeTry\MockServerSDK\Dto\Request\CreateNSpaceRequest;
use CodeTry\MockServerSDK\Dto\Response\AddNSettingsResponse;
use CodeTry\MockServerSDK\Dto\Response\CreateNSpaceResponse;
use CodeTry\MockServerSDK\Exceptions\DeserializeException;
use CodeTry\MockServerSDK\Exceptions\ExternalServerException;
use CodeTry\MockServerSDK\Factory\SerializerFactory;
use GuzzleHttp\Exception\GuzzleException;
use Http\Client\Exception\HttpException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface as PSRClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

class Client implements ClientInterface
{
    private const SERVER_ERROR_HTTP_CODE = 500;
    private string $baseUrl;
    private PSRClientInterface $httpClient;
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;

    public function __construct(
        PSRClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        string $baseUrl
    ) {
        $this->baseUrl = $baseUrl;
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
    }

    public function createNSpace(CreateNSpaceRequest $checkFineRequest): CreateNSpaceResponse
    {
        try {
            return $this->deserialize(
                CreateNSpaceResponse::class,
                $this->doRequest(
                    $checkFineRequest->toPSRRequest(
                        $this->requestFactory,
                        $this->streamFactory,
                        $this->baseUrl
                    )
                )
            );
        } catch (ClientExceptionInterface | GuzzleException $e) {
            throw new ExternalServerException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function addNSettingsToNSpace(AddNSettingsRequest $addNSettingsRequest): AddNSettingsResponse
    {
        try {
            return $this->deserialize(
                AddNSettingsResponse::class,
                $this->doRequest(
                    $addNSettingsRequest->toPSRRequest(
                        $this->requestFactory,
                        $this->streamFactory,
                        $this->baseUrl
                    )
                )
            );
        } catch (ClientExceptionInterface | GuzzleException $e) {
            throw new ExternalServerException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return mixed
     */
    private function deserialize(string $className, ResponseInterface $response)
    {
        if ($response->getBody()->isSeekable()) {
            $response->getBody()->rewind();
        }
        $body = $response->getBody()->getContents() ?: 'null';
        $response->getBody()->close();

        $serializer = (new SerializerFactory())->createSerializer();

        try {
            $dataObject = $serializer->deserialize($body, $className, 'json');
        } catch (\Exception $exception) {
            throw new DeserializeException('Can\'t deserialize data for ' . $className, 0, $exception);
        }

        return $dataObject;
    }

    private function doRequest(RequestInterface $request): ResponseInterface
    {
        $response = $this->httpClient->sendRequest($request);
        if ($response->getStatusCode() >= self::SERVER_ERROR_HTTP_CODE) {
            throw HttpException::create($request, $response);
        }

        return $response;
    }
}
