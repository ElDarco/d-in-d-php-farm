<?php

namespace Middleware\NSpace\UseCase;

use Core\Mongo\SettingsCollectionProxy;
use DTO\NSpace;
use Exceptions\NotFoundExceptions\NamespaceNotFound;
use Factory\DtoFactory;
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
        $persistObject = $settingsCollectionProxy->collection->findOne(['id' => $namespaceId]);

        if (!$persistObject) {
            throw NamespaceNotFound::create();
        }

        $nSpace = DtoFactory::createNSpace();

        $requests = [];
        foreach ($persistObject->requests as $request) {
            $requests[] = $request->getArrayCopy();
        }

        $settings = [];
        foreach ($persistObject->settings as $setting) {
            $settings[] = $setting->getArrayCopy();
        }

        $nSpace->setId($namespaceId);
        $nSpace->setName($persistObject->name);
        $nSpace->setRequests($requests);
        $nSpace->setSettings($settings);

        $this->getRequest()->withAttribute(NSpace::class, $nSpace);
    }
}