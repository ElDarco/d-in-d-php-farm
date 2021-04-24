<?php

namespace Middleware\NSpace\UseCase;

use Core\Mongo\SettingsCollectionProxy;
use DTO\NSpace;
use Exceptions\NotFoundExceptions\NamespaceNotFound;
use Middleware\InvokableMiddleware;

class GetNSpaceInfoByRouteId extends InvokableMiddleware
{
    public function __invoke(
        SettingsCollectionProxy $settingsCollectionProxy
    ) {
        $namespaceId = $this->getRequest()->getRouteParam('nspaceId');

        if (!$namespaceId) {
            throw NamespaceNotFound::create();
        }

        /** @var \MongoDB\Model\BSONDocument $persistObject */
        $persistObject = $settingsCollectionProxy->collection->findOne(['_id' =>  new \MongoDB\BSON\ObjectId($namespaceId)]);

        if (!$persistObject) {
            throw NamespaceNotFound::create();
        }

        $requests = [];
        $nSpace = new NSpace($namespaceId, $persistObject->name);
        foreach ($persistObject->requests as $request) {
            $requests[] = $request->getArrayCopy();
        }
        $nSpace->setRequests($requests);
        $nSpace->setSettings($persistObject->settings->getArrayCopy());

        $this->getRequest()->withAttribute(NSpace::class, $nSpace);
    }
}