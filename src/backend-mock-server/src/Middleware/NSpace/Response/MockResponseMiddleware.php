<?php

namespace Middleware\NSpace\Response;

use Core\DTO\ResponseData;
use DTO\NSettings;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\TextResponse;
use Laminas\Diactoros\Stream;
use Middleware\InvokableMiddleware;

class MockResponseMiddleware extends InvokableMiddleware
{
    public function __invoke(
        NSettings $nSettings = null
    ) {
        if ($nSettings) {
            $bodyRaw = $nSettings->getResponseBody();
            $response = new Response(fopen($bodyRaw, 'rwb+'));
            $response->getBody()->write($bodyRaw);
            $response = $response->withStatus($nSettings->getResponseCode());
            foreach ($nSettings->getHeaders() as $headerKey => $headerValue) {
                $response = $response->withHeader($headerKey, $headerValue);
            }
            return $response;
        }
        return new EmptyResponse(418);
    }
}