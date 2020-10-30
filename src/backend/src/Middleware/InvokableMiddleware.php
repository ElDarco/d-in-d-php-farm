<?php

declare(strict_types=1);

namespace Middleware;

use Core\Middleware\AbstractInvocableMiddleware;
use Core\Middleware\RequestDecorator;
use Core\Middleware\RequestDecoratorInterface;
use Mezzio\Router\RouteResult;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class InvokableMiddleware
 * @abstract
 * @package App\Middleware
 */
class InvokableMiddleware extends AbstractInvocableMiddleware
{
    /**
     * @inheritdoc
     */
    final protected function handleOriginalRequest(ServerRequestInterface $originalRequest): RequestDecoratorInterface
    {
        return new class($originalRequest) extends RequestDecorator {
            public function getRouteParams(): array
            {
                /**
                 * @var RouteResult $route
                 */
                $route = $this->request->getAttribute(RouteResult::class);
                if ($route) {
                    return $route->getMatchedParams();
                }
                return [];
            }
        };
    }
}