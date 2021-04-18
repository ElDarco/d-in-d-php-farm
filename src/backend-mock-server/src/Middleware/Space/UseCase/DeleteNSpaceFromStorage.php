<?php

namespace Middleware\Space\UseCase;

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
            '_id' => new \MongoDB\BSON\ObjectId($nSpace->getId())
        ]);

        $responseData->isDelete = true;
    }
}