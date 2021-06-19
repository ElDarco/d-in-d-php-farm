<?php

declare(strict_types=1);

namespace Core\Middleware;

use Interop\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;

/**
 * Interface InvokableMiddleware
 * @package Core\Middleware
 */
interface InvokableMiddleware extends MiddlewareInterface
{
    /**
     * InvokableMiddleware constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container);

    /**
     * Returns Request object.
     *
     * @return RequestDecoratorInterface
     */
    public function getRequest(): RequestDecoratorInterface;
}