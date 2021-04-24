<?php

namespace Middleware\NRequest\UseCase;

use Core\Mongo\SettingsCollectionProxy;
use DTO\NRequest;
use DTO\NSpace;
use Factory\DtoFactory;
use Middleware\InvokableMiddleware;

class CreateNRequest extends InvokableMiddleware
{
    public function __invoke(
        SettingsCollectionProxy $settingsCollectionProxy
    ) {
        $body = $this->getRequest()->getBody()->getContents();
        $uri = $this->getRequest()->getRouteParam('uri');
        $method = $this->getRequest()->getMethod();
        $queryString = $this->getRequest()->getUri()->getQuery();

        $nRequest = DtoFactory::createNRequest($uri, $method, $body, $queryString);
        $this->getRequest()->withAttribute(NRequest::class, $nRequest);
    }
}