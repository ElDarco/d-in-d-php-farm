<?php

declare(strict_types=1);
namespace Factory;

use Middleware\InvokableMiddleware;
use Interop\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;

/**
 * Class MiddlewareFactory
 * @package App\Factory
 */
class MiddlewareFactory extends AbstractBaseFactory
{
    /**
     * @inheritdoc
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        if (!class_exists($requestedName)) {
            return false;
        }

        // Если middleware унаследован от нашего базового абстрактного класса
        if (in_array(MiddlewareInterface::class, class_parents($requestedName)) ||
            in_array(InvokableMiddleware::class, class_parents($requestedName))
        ) {
            return true;
        }

        return false;
    }
}
