<?php

declare(strict_types=1);

namespace CodeTry\Tests\MockServerSDK;

trait RequestsExamples
{
    public function responseBodyGetNSpaceForTests(
        string $id = 'e3201b9b-76c9-4567-87c8-dabfbc6b6ea7',
        string $name = 'for_unit_test',
        array $settings = [],
        array $requests = [],
        bool $useProxy = false,
        string $proxyToUrl = ''
    ): string {
        return '
        {
            "id": "'. $id .'",
            "name": "'. $name .'",
            "settings": '. json_encode($settings, JSON_THROW_ON_ERROR) .',
            "requests": '. json_encode($requests, JSON_THROW_ON_ERROR) .',
            "useProxy": '. ($useProxy ? 'true' : 'false').',
            "proxyToUrl": "'. $proxyToUrl .'"
        }
        ';
    }
}