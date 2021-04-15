<?php

declare(strict_types=1);

namespace Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;

/**
 * Class AbstractBaseFactory
 * @package App\Middleware
 */
abstract class AbstractBaseFactory implements AbstractFactoryInterface
{
    /**
     * @inheritdoc
     */
    abstract public function canCreate(ContainerInterface $container, $requestedName);
    /**
     * @throws \ReflectionException
     * @inheritdoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        // Инициализируем рефлексию
        $reflection = new \ReflectionClass($requestedName);

        // Возьмем информацию о конструкторе
        $constructor = $reflection->getConstructor();

        if (is_null($constructor)) {
            return new $requestedName;
        }

        // Получим параметры конструктора
        $parameters = $constructor->getParameters();
        $dependencies = [];
        foreach ($parameters as $parameter) {
            // Получим нужный класс
            $name = $parameter->getType() && !$parameter->getType()->isBuiltin()
                ? $parameter->getType()->getName()
                : null;
            if ($name) {
                // Если просят сам контейнер - отдадим.
                if ($name === ContainerInterface::class) {
                    $dependencies[] = $container;
                } // иначе возьмем нужный класс из di контейнера
                else {
                    $dependencies[] = $container->get($name);
                }
            }
        }

        // Return the requested class and inject its dependencies
        return $reflection->newInstanceArgs($dependencies);
    }
}
