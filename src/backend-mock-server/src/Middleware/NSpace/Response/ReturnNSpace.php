<?php

namespace Middleware\NSpace\Response;

use Core\DTO\ResponseData;
use Core\Mongo\SettingsCollectionProxy;
use DTO\NSpace;
use Exceptions\NotFoundExceptions\NamespaceNotFound;
use Middleware\InvokableMiddleware;

class ReturnNSpace extends InvokableMiddleware
{
    public function __invoke(
        ResponseData $responseData,
        NSpace $nSpace
    ) {
        $responseData->id = $nSpace->getId();
        $responseData->name = $nSpace->getName();
        $responseData->settings = $nSpace->getSettings();
        $responseData->requests = $nSpace->getRequests();
        $this->getRequest()->withAttribute(ResponseData::class, $responseData);
    }
}