<?php

declare(strict_types=1);

namespace Middleware;

use Exceptions\ServerErrorException;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ErrorFactoryMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $e) {
            if ($e instanceof ProblemDetailsExceptionInterface) {
                throw $e;
            }

            $additional = [];
            if ($_ENV['APP_HUB_WORK_MODE'] === 'dev') {
                $additional['trace'] = $e->getTraceAsString();
                $additional['message'] = $e->getMessage();
                $additional['code'] = $e->getCode();
            }
            throw ServerErrorException::create(
                'unknownServerErrorException',
                'Something Went Wrong',
                $additional
            );
        }
    }
}
