<?php

declare(strict_types=1);

namespace App\Middleware;
use Psr\Http\Message\ServerRequestInterface;
/**
 * Class Middleware
 * @abstract
 * @package App\Middleware
 */
abstract class AbstractMiddleware extends AbstractInvocableMiddleware
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