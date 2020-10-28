<?php

namespace Middleware;

use Exceptions\ServerErrorException;
use Laminas\Diactoros\Response\JsonResponse;

class SuccessMiddleware extends InvokableMiddleware
{
    public function __invoke()
    {
        return new JsonResponse([], 200);
    }
}