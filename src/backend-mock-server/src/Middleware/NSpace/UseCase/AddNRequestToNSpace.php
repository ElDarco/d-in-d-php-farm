<?php

namespace Middleware\NSpace\UseCase;

use Core\DTO\ResponseData;
use Core\Mongo\SettingsCollectionProxy;
use DTO\NRequest;
use DTO\NSpace;
use Exceptions\NotFoundExceptions\NamespaceNotFound;
use Middleware\InvokableMiddleware;

class AddNRequestToNSpace extends InvokableMiddleware
{
    public function __invoke(
        NRequest $nRequest,
        SettingsCollectionProxy $settingsCollectionProxy,
        NSpace $nSpace
    ) {
        /** @var \MongoDB\Model\BSONDocument $persistObject */
        $settingsCollectionProxy->collection->updateOne(
            [
                '_id' =>  new \MongoDB\BSON\ObjectId($nSpace->getId())
            ],
            [
                '$push' =>[
                    'requests' => $nRequest->toArray()
                ]
            ]
        );

        $this->getRequest()->withAttribute(NSpace::class, $nSpace);
    }
}