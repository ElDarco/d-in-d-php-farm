<?php

namespace Middleware\NSettings\UseCase;

use Core\DTO\ResponseData;
use Core\Mongo\SettingsCollectionProxy;
use DTO\NSettings;
use DTO\NSpace;
use Middleware\InvokableMiddleware;

class ClearNSettings extends InvokableMiddleware
{
    public function __invoke(
        NSpace $nSpace,
        SettingsCollectionProxy $settingsCollectionProxy,
        ResponseData $responseData
    ) {

        $settings = [];

        /** @var \MongoDB\Model\BSONDocument $persistObject */
        $settingsCollectionProxy->collection->updateOne(
            [
                'id' => $nSpace->getId()
            ],
            [
                '$set' =>[
                    'settings' => $settings
                ]
            ]
        );

        $responseData->isClear = true;
    }
}