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
        $nSpace->addRequests($nRequest);
        $nRequestArrayToPersist = [];
        foreach ($nSpace->sliceRequests() as $nRequestObject) {
            $nRequestArrayToPersist[] = $nRequestObject->toArray();
        }
        /** @var \MongoDB\Model\BSONDocument $persistObject */
        $settingsCollectionProxy->collection->updateOne(
            [
                'id' => $nSpace->getId()
            ],
            [
                '$set' => [
                    'requests' => $nRequestArrayToPersist
                ]
            ]
        );

        $this->getRequest()->withAttribute(NSpace::class, $nSpace);
    }
}