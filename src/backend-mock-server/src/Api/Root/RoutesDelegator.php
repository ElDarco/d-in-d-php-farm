<?php

declare(strict_types=1);

namespace Api\Root;

use Mezzio\Application;
use Mezzio\ProblemDetails\ProblemDetailsMiddleware;
use Middleware\Space\UseCase\GetNewNSpace;
use Psr\Container\ContainerInterface;

/**
 * Pipeline.
 *
 * Class RoutesDelegator
 * @package App
 */
class RoutesDelegator
{
    const UUID_REGEXP = "[a-f0-9\-]{36}";
    const OTHER_PATH_REGEXP = ".*";

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

        $uuidRegexp = self::UUID_REGEXP;
        $otherPathRegexp = self::OTHER_PATH_REGEXP;

        $app->any("/n/{nspaceId:{$uuidRegexp}}[{uri:{$otherPathRegexp}}]", [
            \Middleware\NSpace\UseCase\GetNSpaceInfoByRouteId::class,
            \Middleware\NRequest\UseCase\CreateNRequest::class,
            \Middleware\NSpace\UseCase\AddNRequestToNSpace::class,
            \Middleware\NSettings\UseCase\FindSuitableNSetting::class,
            \Middleware\NSpace\Response\MockResponseMiddleware::class
        ]);

        return $app;
    }
    // @codingStandardsIgnoreEnd
}