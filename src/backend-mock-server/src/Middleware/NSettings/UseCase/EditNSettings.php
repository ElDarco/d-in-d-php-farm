<?php

namespace Middleware\NSettings\UseCase;

use Core\DTO\ResponseData;
use Core\Mongo\SettingsCollectionProxy;
use DTO\NSettings;
use DTO\NSpace;
use Middleware\InvokableMiddleware;

class EditNSettings extends InvokableMiddleware
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

        $body = $this->getRequest()->getParsedBody()['body'] ?? '';
        $uri = $this->getRequest()->getParsedBody()['uri'] ?? '';
        $method = $this->getRequest()->getParsedBody()['method'] ?? '';
        $code = (int) ($this->getRequest()->getParsedBody()['code'] ?? 0);
        $headers = $this->getRequest()->getParsedBody()['headers'] ?? [];
        $queryString = $this->getRequest()->getParsedBody()['queryString'] ?? '';

        $nSettings->setResponseBody($body);
        $nSettings->setUri($uri);
        $nSettings->setMethod($method);
        $nSettings->setResponseCode($code);
        $nSettings->setHeaders($headers);
        $nSettings->setQueryString($queryString);
        $settingsObjects[] = $nSettings;

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

        $this->getRequest()->withAttribute(NSettings::class, $nSettings);
    }
}