<?php

namespace Middleware\NSpace\UseCase;

use Core\Mongo\SettingsCollectionProxy;
use DTO\NSpace;
use Factory\DtoFactory;
use Middleware\InvokableMiddleware;

class GetNewNSpace extends InvokableMiddleware
{
    public function __invoke(
        SettingsCollectionProxy $settingsCollectionProxy
    ) {
        $name = $this->getRequest()->getParsedBody()['name'] ?? '';
        $useProxy = $this->getRequest()->getParsedBody()['useProxy'] ?? false;
        $proxyToUrl = $this->getRequest()->getParsedBody()['proxyToUrl'] ?? '';

        $nSpace = DtoFactory::createNSpace($name, $useProxy, $proxyToUrl);
        $settingsCollectionProxy->collection->insertOne($nSpace->toArray());

        $this->getRequest()->withAttribute(NSpace::class, $nSpace);
    }
}