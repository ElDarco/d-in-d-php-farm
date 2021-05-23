<?php

declare(strict_types=1);

namespace Api\ExternalApi\v1;

use Mezzio\Application;
use Mezzio\ProblemDetails\ProblemDetailsMiddleware;
use Middleware\NSettings\UseCase\CreateNSettings;
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


        $app->post($basePath . '/nspace[/]', [
            \Middleware\NSpace\UseCase\GetNewNSpace::class,
            \Middleware\NSpace\Response\ReturnNSpace::class,
            \Middleware\SuccessMiddleware::class
        ]);

        $app->get($basePath . '/nspace/{nspaceId}[/]', [
            \Middleware\NSpace\UseCase\GetNSpaceInfoByRouteId::class,
            \Middleware\NSpace\Response\ReturnNSpace::class,
            \Middleware\SuccessMiddleware::class
        ]);

        $app->patch($basePath . '/nspace/{nspaceId}[/]', [
            \Middleware\NSpace\UseCase\GetNSpaceInfoByRouteId::class,
            \Middleware\NSpace\UseCase\EditNSpaceInfoFromRequest::class,
            \Middleware\NSpace\Response\ReturnNSpace::class,
            \Middleware\SuccessMiddleware::class
        ]);

        $app->delete($basePath . '/nspace/{nspaceId}[/]', [
            \Middleware\NSpace\UseCase\GetNSpaceInfoByRouteId::class,
            \Middleware\NSpace\UseCase\DeleteNSpaceFromStorage::class,
            \Middleware\SuccessMiddleware::class
        ]);


        $app->post($basePath . '/nspace/{nspaceId}/settings/add[/]', [
            \Middleware\NSpace\UseCase\GetNSpaceInfoByRouteId::class,
            \Middleware\NSettings\UseCase\CreateNSettings::class,
            \Middleware\NSpace\UseCase\AddNSettingsToNSpace::class,
            \Middleware\NSpace\Response\ReturnNSpace::class,
            \Middleware\SuccessMiddleware::class
        ]);

        $app->get($basePath . '/nspace/{nspaceId}/settings/{settingId}[/]', [
            \Middleware\NSpace\UseCase\GetNSpaceInfoByRouteId::class,
            \Middleware\NSettings\UseCase\GetNSettingsByUuid::class,
            \Middleware\NSettings\Response\ReturnNSettings::class,
            \Middleware\SuccessMiddleware::class
        ]);

        $app->patch($basePath . '/nspace/{nspaceId}/settings/{settingId}[/]', [
            \Middleware\NSpace\UseCase\GetNSpaceInfoByRouteId::class,
            \Middleware\NSettings\UseCase\GetNSettingsByUuid::class,
            \Middleware\NSettings\UseCase\EditNSettings::class,
            \Middleware\NSettings\Response\ReturnNSettings::class,
            \Middleware\SuccessMiddleware::class
        ]);

        $app->delete($basePath . '/nspace/{nspaceId}/settings/{settingId}[/]', [
            \Middleware\NSpace\UseCase\GetNSpaceInfoByRouteId::class,
            \Middleware\NSettings\UseCase\GetNSettingsByUuid::class,
            \Middleware\NSettings\UseCase\DeleteNSettings::class,
            \Middleware\SuccessMiddleware::class
        ]);

        $app->post($basePath . '/nspace/{nspaceId}/settings/clear[/]', [
            \Middleware\NSpace\UseCase\GetNSpaceInfoByRouteId::class,
            \Middleware\NSettings\UseCase\ClearNSettings::class,
            \Middleware\SuccessMiddleware::class
        ]);

        return $app;
    }
    // @codingStandardsIgnoreEnd
}
