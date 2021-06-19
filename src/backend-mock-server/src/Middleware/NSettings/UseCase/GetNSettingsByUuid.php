<?php

namespace Middleware\NSettings\UseCase;

use Core\Mongo\SettingsCollectionProxy;
use DTO\NRequest;
use DTO\NSettings;
use DTO\NSpace;
use Exceptions\NotFoundExceptions\SettingsNotFound;
use Factory\DtoFactory;
use Middleware\InvokableMiddleware;

class GetNSettingsByUuid extends InvokableMiddleware
{
    public function __invoke(
        NSpace $nSpace,
        SettingsCollectionProxy $settingsCollectionProxy
    ) {
        $settingsId = $this->getRequest()->getRouteParam('settingId');

        /** @var NSettings $settings */
        foreach ($nSpace->getSettingsObjects() as $nSettings) {
            if ($nSettings->getId() === $settingsId) {
                $this->getRequest()->withAttribute(NSettings::class, $nSettings);
                return;
            }
        }

        throw SettingsNotFound::create();
    }
}