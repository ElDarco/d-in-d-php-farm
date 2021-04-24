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
            return new TextResponse($nSettings->getResponseBody(), $nSettings->getResponseCode());
        }
        return new EmptyResponse(418);
    }
}