<?php

namespace Middleware\NSettings\UseCase;

use Core\DTO\ResponseData;
use Core\Mongo\SettingsCollectionProxy;
use DTO\NSettings;
use DTO\NSpace;
use Middleware\InvokableMiddleware;

class DeleteNSettings extends InvokableMiddleware
{
    public function __invoke(
        NSpace $nSpace,
        NSettings $nSettings,
        SettingsCollectionProxy $settingsCollectionProxy,
        ResponseData $responseData
    ) {
        $settingsObjects = [];
        /** @var NSettings $settingsObject */
        foreach ($nSpace->getSettingsObjects() as $settingsObject) {
            if ($nSettings->getId() !== $settingsObject->getId()) {
                $settingsObjects[] = $nSettings;
            }
        }

        $settings = [];
        foreach ($settingsObjects as $settingsObject) {
            $settings[] = $settingsObject->toArray();
        }

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

        $responseData->isDelete = true;
    }
}