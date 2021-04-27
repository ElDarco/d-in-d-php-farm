<?php

namespace Middleware\NSpace\Response;

use Core\DTO\ResponseData;
use Core\Mongo\SettingsCollectionProxy;
use DTO\NSettings;
use DTO\NSpace;
use Exceptions\NotFoundExceptions\NamespaceNotFound;
use Middleware\InvokableMiddleware;

class ReturnNSettings extends InvokableMiddleware
{
    public function __invoke(
        ResponseData $responseData,
        NSettings $nSettings
    ) {
        $responseData->id = $nSettings->getId();
        $responseData->uri = $nSettings->getUri();
        $responseData->method = $nSettings->getMethod();
        $responseData->responseBody = $nSettings->getResponseBody();
        $responseData->responseCode = $nSettings->getResponseCode();
        $responseData->queryString = $nSettings->getQueryString();
        $responseData->headers = $nSettings->getHeaders();
        $this->getRequest()->withAttribute(ResponseData::class, $responseData);
    }
}