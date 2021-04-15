<?php

declare(strict_types=1);

namespace Api\ExternalApi\v1;

use Mezzio\Application;
use Mezzio\ProblemDetails\ProblemDetailsMiddleware;
use Psr\Container\ContainerInterface;

/**
 * Pipeline.
 *
 * Class RoutesDelegator
 * @package App
 */
class RoutesDelegator
{
    // @codingStandardsIgnoreStart
    /**
     * @param ContainerInterface $container
     * @param string $serviceName Name of the service being created.
     * @param callable $callback Creates and returns the service.
     * @return Application
     */
    public function __invoke(ContainerInterface $container, $serviceName, callable $callback) : Application
    {
        /** @var $app Application */
        $app = $callback();

        $basePath   = '/api/v1';

        $app->get($basePath . '/ping[/]', [
            \Middleware\SuccessMiddleware::class
        ]);

        return $app;
    }
    // @codingStandardsIgnoreEnd
}
