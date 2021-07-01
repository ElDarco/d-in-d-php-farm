<?php

declare(strict_types=1);

namespace CodeTry\Tests\MockServerSDK\Dto\Request;

use CodeTry\MockServerSDK\Dto\Request\CreateNSpaceRequest;
use PHPUnit\Framework\TestCase;

class CreateNSpaceTest extends TestCase
{
    public function testGetBody(): void
    {
        $request = new CreateNSpaceRequest('for_test', false, '');
        $expectedJsonBody = '{"name":"for_test","use_proxy":false,"proxy_to_url":""}';
        self::assertEquals($expectedJsonBody, $request->getBody());
    }
}
