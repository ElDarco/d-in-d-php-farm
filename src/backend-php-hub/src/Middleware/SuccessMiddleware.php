<?php

namespace Middleware;

use Core\DTO\ResponseData;
use Laminas\Diactoros\Response\JsonResponse;

/**
 * Class SuccessMiddleware
 * @package Middleware
 */
class SuccessMiddleware extends InvokableMiddleware
{
    /**
     * @param ResponseData $return
     * @return JsonResponse
     */
    public function __invoke(
        ResponseData $return
    ) {
        return new JsonResponse($return->__toArray(), 200);
    }
}