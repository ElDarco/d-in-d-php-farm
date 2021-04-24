<?php

namespace Middleware\NSpace\UseCase;

use Core\DTO\ResponseData;
use Core\Mongo\SettingsCollectionProxy;
use DTO\NSpace;
use Exceptions\NotFoundExceptions\NamespaceNotFound;
use Middleware\InvokableMiddleware;

class DeleteNSpaceFromStorage extends InvokableMiddleware
{
    public function __invoke(
        NSpace $nSpace,
        SettingsCollectionProxy $settingsCollectionProxy,
        ResponseData $responseData
    ) {
        /** @var \MongoDB\Model\BSONDocument $persistObject */
        $settingsCollectionProxy->collection->deleteOne([
            'id' => $nSpace->getId()
        ]);

        $responseData->isDelete = true;
    }
}