<?php

declare(strict_types=1);

namespace Middleware\Response;

use Core\DTO\ResponseData;
use Middleware\InvokableMiddleware;

/**
 * Class InitResponseDataMiddleware
 * @package App\InvokedMiddleware
 */
class InitResponseDataMiddleware extends InvokableMiddleware
{
    public function __invoke()
    {
        $this->getRequest()->withAttribute(ResponseData::class, new ResponseData());
    }
}
