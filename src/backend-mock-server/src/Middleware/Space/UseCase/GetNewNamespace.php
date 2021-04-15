<?php

namespace Middleware\Space\UseCase;

use Core\DTO\ResponseData;
use Middleware\InvokableMiddleware;

class GetNewNamespace extends InvokableMiddleware
{
    public function __invoke(
        ResponseData $responseData
    ) {
        $responseData->namespace = [];
    }

}