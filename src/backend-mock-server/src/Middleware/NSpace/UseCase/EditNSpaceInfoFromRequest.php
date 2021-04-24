<?php

namespace Middleware\NSpace\UseCase;

use Core\Mongo\SettingsCollectionProxy;
use DTO\NSpace;
use Exceptions\NotFoundExceptions\NamespaceNotFound;
use Middleware\InvokableMiddleware;

class EditNSpaceInfoFromRequest extends InvokableMiddleware
{
    public function __invoke(
        NSpace $nSpace,
        SettingsCollectionProxy $settingsCollectionProxy
    ) {
        $body = $this->getRequest()->getParsedBody() ?? [];
        $name = $body['name'] ?? '';

        if ($name) {
            $nSpace->setName($name);
        }

        /** @var \MongoDB\Model\BSONDocument $persistObject */
        $settingsCollectionProxy->collection->updateOne(
            [
                'id' => $nSpace->getId()
            ],
            [
                '$set' =>[
                    'name' => $nSpace->getName()
                ]
            ]
        );

        $this->getRequest()->withAttribute(NSpace::class, $nSpace);
    }
}