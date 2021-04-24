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

        $nSpace = DtoFactory::createNSpace($name);
        $settingsCollectionProxy->collection->insertOne($nSpace->toArray());

        $this->getRequest()->withAttribute(NSpace::class, $nSpace);
    }
}