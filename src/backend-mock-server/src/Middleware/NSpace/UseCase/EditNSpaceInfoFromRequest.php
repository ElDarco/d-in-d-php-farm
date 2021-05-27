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
        $useProxy = $body['useProxy'] ?? false;
        $proxyToUrl = $body['proxyToUrl'] ?? '';

        if ($name) {
            $nSpace->setName($name);
        }
        if ($useProxy) {
            $nSpace->setUseProxy($useProxy);
        }
        if ($proxyToUrl) {
            $nSpace->setProxyToUrl($proxyToUrl);
        }

        /** @var \MongoDB\Model\BSONDocument $persistObject */
        $settingsCollectionProxy->collection->updateOne(
            [
                'id' => $nSpace->getId()
            ],
            [
                '$set' =>[
                    'name' => $nSpace->getName(),
                    'useProxy' => $nSpace->isUseProxy(),
                    'proxyToUrl' => $nSpace->getProxyToUrl(),
                ]
            ]
        );

        $this->getRequest()->withAttribute(NSpace::class, $nSpace);
    }
}