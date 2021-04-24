<?php

namespace Middleware\NSpace\UseCase;

use Core\Mongo\SettingsCollectionProxy;
use DTO\NSpace;
use Middleware\InvokableMiddleware;

class GetNewNSpace extends InvokableMiddleware
{
    public function __invoke(
        SettingsCollectionProxy $settingsCollectionProxy
    ) {
        $body = $this->getRequest()->getParsedBody() ?? [];
        $name = $body['name'] ?? '';
        if (!$name) {
            $name = 'somename_' . microtime(true);
        }
        $persistObject = $settingsCollectionProxy->collection->insertOne([
            'settings' => [],
            'requests' => [],
            'name' => $name
        ]);

        /** @var \MongoDB\BSON\ObjectId $mongoId */
        $mongoId = $persistObject->getInsertedId();

        $id = $mongoId->__toString();
        $nSpace = new NSpace($id, $name);

        $this->getRequest()->withAttribute(NSpace::class, $nSpace);
    }
}