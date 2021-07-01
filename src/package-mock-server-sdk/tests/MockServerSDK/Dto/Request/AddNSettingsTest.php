<?php

declare(strict_types=1);

namespace CodeTry\Tests\MockServerSDK\Dto\Request;

use CodeTry\MockServerSDK\Dto\Request\AddNSettingsRequest;
use PHPUnit\Framework\TestCase;

class AddNSettingsTest extends TestCase
{
    public function testGetBody(): void
    {
        $response = ['test' => 'test'];
        $request = new AddNSettingsRequest('123', \json_encode($response), "/v1.3/fines", 'GET', 200, [], '');
        $expectedJsonBody = '{"body":"{\"test\":\"test\"}","uri":"\/v1.3\/fines","method":"GET","code":200,"headers":[],"queryString":""}';
        $expectedUri = 'api/v1/nspace/123/settings/add';
        self::assertEquals($expectedJsonBody, $request->getBody());
        self::assertEquals($expectedUri, $request->getPath());
    }
}
