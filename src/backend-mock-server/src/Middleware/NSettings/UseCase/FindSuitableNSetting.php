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
        NSpace $nSpace,
        SettingsCollectionProxy $settingsCollectionProxy
    ) {
        /** @var NSettings $nSettings */
        foreach ($nSpace->getSettingsObjects() as $nSettings) {
            if (
                $nSettings->getMethod() === $nRequest->getMethod()
                && $nSettings->getUri() === $nRequest->getUri()
                && $nSettings->getQueryString() === $nRequest->getQueryString()
            ) {
                $this->getRequest()->withAttribute(NSettings::class, $nSettings);
                break;
            }
        }
        foreach ($nSpace->getSettingsObjects() as $nSettings) {
            if (
                $nSettings->getMethod() === $nRequest->getMethod()
                && $nSettings->getUri() === $nRequest->getUri()
            ) {
                if ($nSettings->getQueryString() === '') {
                    continue;
                }
                parse_str($nSettings->getQueryString(), $queryParamsInSettings);
                parse_str($nRequest->getQueryString(), $queryParamsInRequest);
                $needBeEqual = \count($queryParamsInSettings);
                $realBeEqual = 0;
                foreach ($queryParamsInRequest as $keyQueryParamInRequest => $queryParamInRequestValue) {
                    if ($queryParamsInSettings[$keyQueryParamInRequest] === $queryParamInRequestValue) {
                        $realBeEqual++;
                    }
                }
                if ($realBeEqual === $needBeEqual) {
                    $this->getRequest()->withAttribute(NSettings::class, $nSettings);
                    break;
                }

                break;
            }
        }
        foreach ($nSpace->getSettingsObjects() as $nSettings) {
            if (
                $nSettings->getQueryString() === ""
                && $nSettings->getMethod() === $nRequest->getMethod()
                && $nSettings->getUri() === $nRequest->getUri()
            ) {
                $this->getRequest()->withAttribute(NSettings::class, $nSettings);
                break;
            }
        }
    }
}