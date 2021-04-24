<?php

namespace Middleware\NSpace\Response;

use Core\DTO\ResponseData;
use DTO\NSettings;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\TextResponse;
use Middleware\InvokableMiddleware;

class MockResponseMiddleware extends InvokableMiddleware
{
    public function __invoke(
        NSettings $nSettings = null
    ) {
        if ($nSettings) {
            $response = new TextResponse($nSettings->getResponseBody(), $nSettings->getResponseCode());
            foreach ($nSettings->getHeaders() as $headerValue => $headerKey) {
                $response->withHeader($headerKey, $headerValue);
            }
            return $response;
        }
        return new EmptyResponse(418);
    }
}