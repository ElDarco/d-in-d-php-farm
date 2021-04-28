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

        $nSpace->setId($namespaceId);
        $nSpace->setName($persistObject->name);

        foreach ($persistObject->requests as $request) {
            $nRequest = DtoFactory::createNRequest(
                $request->uri,
                $request->method,
                $request->body,
                $request->queryString,
                $request->createdAt
            );
            $nSpace->addRequests($nRequest);
        }

        foreach ($persistObject->settings as $setting) {
            $nSettings = DtoFactory::createNSettings(
                $setting->uri,
                $setting->method,
                $setting->responseBody,
                $setting->responseCode,
                $setting->queryString,
                $setting->headers->getArrayCopy()
            );
            $nSpace->addSettings($nSettings);
        }
        $this->getRequest()->withAttribute(NSpace::class, $nSpace);
    }
}