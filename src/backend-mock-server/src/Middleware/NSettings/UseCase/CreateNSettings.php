<?php

namespace Middleware\NSettings\UseCase;

use Core\Mongo\SettingsCollectionProxy;
use DTO\NRequest;
use DTO\NSettings;
use DTO\NSpace;
use Factory\DtoFactory;
use Middleware\InvokableMiddleware;

class CreateNSettings extends InvokableMiddleware
{
    public function __invoke(
        SettingsCollectionProxy $settingsCollectionProxy
    ) {
        $body = $this->getRequest()->getParsedBody()['body'] ?? '';
        $uri = $this->getRequest()->getParsedBody()['uri'] ?? '';
        $method = $this->getRequest()->getParsedBody()['method'] ?? '';
        $code = (int) ($this->getRequest()->getParsedBody()['code'] ?? 0);
        $headers = $this->getRequest()->getParsedBody()['headers'] ?? [];
        $queryString = $this->getRequest()->getParsedBody()['queryString'] ?? '';

        $nSettings = DtoFactory::createNSettings($uri, $method, $body, $code, $queryString, $headers);
        $this->getRequest()->withAttribute(NSettings::class, $nSettings);
    }
}