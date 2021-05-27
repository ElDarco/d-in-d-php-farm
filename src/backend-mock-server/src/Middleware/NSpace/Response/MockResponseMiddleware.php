<?php

namespace Middleware\NSpace\Response;

use Core\DTO\ResponseData;
use DTO\NRequest;
use DTO\NSettings;
use DTO\NSpace;
use GuzzleHttp\Client;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\TextResponse;
use Laminas\Diactoros\Stream;
use Middleware\InvokableMiddleware;
use Psr\Http\Message\ResponseInterface;

class MockResponseMiddleware extends InvokableMiddleware
{
    public function __invoke(
        ResponseInterface $response = null
    ) {
        if ($response) {
            return $response;
        }

        return new EmptyResponse(418);
    }
}