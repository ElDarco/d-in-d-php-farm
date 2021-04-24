<?php

namespace Middleware\NSettings\UseCase;

use Core\Mongo\SettingsCollectionProxy;
use DTO\NRequest;
use DTO\NSettings;
use DTO\NSpace;
use Factory\DtoFactory;
use Middleware\InvokableMiddleware;

class FindSuitableNSetting extends InvokableMiddleware
{
    public function __invoke(
        NRequest $nRequest,
        SettingsCollectionProxy $settingsCollectionProxy
    ) {
        $settingSearch = [];
        if ($nRequest->getMethod()) {
            $settingSearch['method'] = $nRequest->getMethod();
        }
        if ($nRequest->getUri()) {
            $settingSearch['uri'] = $nRequest->getUri();
        }
        if ($nRequest->getUri()) {
            $settingSearch['queryString'] = $nRequest->getQueryString();
        }

        /** @var \MongoDB\Model\BSONDocument $persistObject */
        $persistObject = $settingsCollectionProxy->collection->findOne([
            'settings' => $settingSearch
        ]);

        if ($persistObject) {
            $headers = [];
            foreach ($persistObject->headers as $header) {
                $headers[] = $header->getArrayCopy();
            }
            $nSettings = DtoFactory::createNSettings(
                $persistObject->uri,
                $persistObject->method,
                $persistObject->body,
                $persistObject->code,
                $persistObject->queryString,
                $headers
            );

            $this->getRequest()->withAttribute(NSettings::class, $nSettings);
        }
    }
}