<?php

namespace Middleware\NSpace\UseCase;

use Core\DTO\ResponseData;
use Core\Mongo\SettingsCollectionProxy;
use DTO\NRequest;
use DTO\NSettings;
use DTO\NSpace;
use Exceptions\NotFoundExceptions\NamespaceNotFound;
use Middleware\InvokableMiddleware;

class AddNSettingsToNSpace extends InvokableMiddleware
{
    public function __invoke(
        NSettings $nSetting,
        SettingsCollectionProxy $settingsCollectionProxy,
        NSpace $nSpace
    ) {
        /** @var \MongoDB\Model\BSONDocument $persistObject */
        $settingsCollectionProxy->collection->updateOne(
            [
                'id' => $nSpace->getId()
            ],
            [
                '$push' =>[
                    'settings' => $nSetting->toArray()
                ]
            ]
        );

        $nSpace->addSettings($nSetting);

        $this->getRequest()->withAttribute(NSpace::class, $nSpace);
    }
}