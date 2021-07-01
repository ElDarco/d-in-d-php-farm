<?php

declare(strict_types=1);

namespace CodeTry\Tests\MockServerSDK;

use CodeTry\MockServerSDK\Client;
use CodeTry\MockServerSDK\Dto\Request\CreateNSpaceRequest;
use CodeTry\MockServerSDK\Exceptions\ExternalServerException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

class ClientTest extends TestCase
{
    use RequestsExamples;

    public function testCreateNSpaceBeRequest(): void
    {
        $requestFactoryStub = $this->getMockBuilder(RequestFactoryInterface::class)->getMock();
        $streamFactoryStub = $this->getMockBuilder(StreamFactoryInterface::class)->getMock();

        $streamInterfaceStub = $this->getMockBuilder(StreamInterface::class)->getMock();
        $streamInterfaceStub->method('isSeekable')->willReturn(true);
        $streamInterfaceStub->method('getContents')->willReturn($this->responseBodyGetNSpaceForTests());

        $responseInterfaceStub = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $responseInterfaceStub->method('getStatusCode')->willReturn(200);
        $responseInterfaceStub->method('getBody')->willReturn($streamInterfaceStub);

        $httpClientStub = $this->getMockBuilder(ClientInterface::class)->getMock();
        $httpClientStub->method('sendRequest')->willReturn($responseInterfaceStub);

        $createNSpaceMock = $this->getMockBuilder(CreateNSpaceRequest::class)->disableOriginalConstructor()->getMock();
        $createNSpaceMock->expects(self::once())->method('toPSRRequest');

        $client = new Client($httpClientStub, $requestFactoryStub, $streamFactoryStub, 'someBaseUrl');
        $client->createNSpace($createNSpaceMock);
    }

    public function testCatchExceptionCheckFineBeRequest(): void
    {
        $requestFactoryStub = $this->getMockBuilder(RequestFactoryInterface::class)->getMock();
        $streamFactoryStub = $this->getMockBuilder(StreamFactoryInterface::class)->getMock();
        $clientExceptionInterfaceStub = $this->getMockBuilder(ClientExceptionInterface::class)->getMock();

        $httpClientStub = $this->getMockBuilder(ClientInterface::class)->getMock();
        $httpClientStub->method('sendRequest')->willThrowException($clientExceptionInterfaceStub);

        $createNSpaceMock = $this->getMockBuilder(CreateNSpaceRequest::class)->disableOriginalConstructor()->getMock();
        $createNSpaceMock->expects(self::once())->method('toPSRRequest');

        $client = new Client($httpClientStub, $requestFactoryStub, $streamFactoryStub, 'someBaseUrl');

        $this->expectException(ExternalServerException::class);
        $client->createNSpace($createNSpaceMock);
    }

    public function testCreateNSpaceResponseConsist(): void
    {
        $expectedID = 'e3201b9b-76c9-4567-87c8-dabfbc6b6ea7';
        $expectedName = 'somename';
        $expectedRequests = [];
        $expectedSettings = [];
        $expectedUseProxy = false;
        $expectedUrlToProxy = 'someurl';

        $requestFactoryStub = $this->getMockBuilder(RequestFactoryInterface::class)->getMock();
        $streamFactoryStub = $this->getMockBuilder(StreamFactoryInterface::class)->getMock();

        $streamInterfaceStub = $this->getMockBuilder(StreamInterface::class)->getMock();
        $streamInterfaceStub->method('isSeekable')->willReturn(true);
        $streamInterfaceStub->method('getContents')->willReturn(
            $this->responseBodyGetNSpaceForTests(
                $expectedID,
                $expectedName,
                $expectedSettings,
                $expectedRequests,
                $expectedUseProxy,
                $expectedUrlToProxy
            )
        );

        $responseInterfaceStub = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $responseInterfaceStub->method('getStatusCode')->willReturn(200);
        $responseInterfaceStub->method('getBody')->willReturn($streamInterfaceStub);

        $httpClientStub = $this->getMockBuilder(ClientInterface::class)->getMock();
        $httpClientStub->method('sendRequest')->willReturn($responseInterfaceStub);

        $createNSpaceRequestMock = $this->getMockBuilder(CreateNSpaceRequest::class)->disableOriginalConstructor()->getMock();

        $client = new Client($httpClientStub, $requestFactoryStub, $streamFactoryStub, 'someBaseUrl');
        $createNSpaceResponse = $client->createNSpace($createNSpaceRequestMock);

        self::assertEquals($expectedID, $createNSpaceResponse->getId());
        self::assertEquals($expectedName, $createNSpaceResponse->getName());
        self::assertEquals($expectedRequests, $createNSpaceResponse->getRequests());
        self::assertEquals($expectedSettings, $createNSpaceResponse->getSettings());
        self::assertFalse($createNSpaceResponse->getUseProxy());
        self::assertEquals($expectedUrlToProxy, $createNSpaceResponse->getProxyToUrl());
    }
}
