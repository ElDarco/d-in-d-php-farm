<?php

declare(strict_types=1);

namespace Core\Middleware;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class InvokableMiddleware
 * @package Core\Middleware
 *
 * @method __invoke()
 */
abstract class AbstractInvocableMiddleware implements InvokableMiddleware
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var RequestDecoratorInterface
     */
    private $request;

    /**
     * @inheritdoc
     */
    final public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Should create Request object that implements RequestInterface and wraps original request object.
     *
     * @param ServerRequestInterface $originalRequest
     * @return RequestDecoratorInterface
     */
    abstract protected function handleOriginalRequest(ServerRequestInterface $originalRequest): RequestDecoratorInterface;

    /**
     * @throws MiddlewareException
     * @inheritdoc
     */
    final public function process(
        ServerRequestInterface $originalRequest,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        if ($originalRequest instanceof RequestDecoratorInterface) {
            $this->setRequest($originalRequest);
        } else {
            $this->setRequest($this->handleOriginalRequest($originalRequest));
        }

        // Инициализируем рефлексию
        $reflection = new \ReflectionClass($this);

        if (!$reflection->hasMethod('__invoke')) {
            throw new MiddlewareException('methodInvokeDoesntExists');
        }

        // Возьмем информацию о конструкторе
        $method = $reflection->getMethod('__invoke');

        if (is_null($method)) {
            throw new MiddlewareException('invalidMiddleware');
        }

        // Получим параметры конструктора
        /**
         * @var \ReflectionParameter[] $parameters
         */
        $parameters = $method->getParameters();
        $dependencies = [];
        foreach ($parameters as $parameter) {
            // в аргументах могут быть только объекты, являющиеся экземплярами определенных классов или реализующие определенные интерфейсы
            if (!class_exists($parameter->getType()->getName()) && !interface_exists(
                    $parameter->getType()->getName()
                )) {
                throw new MiddlewareException(
                    'The argument #' . $parameter->getPosition() . ' must has class or interface related type'
                );
            }
            // Получим нужный класс
            $class = $parameter->getType() && !$parameter->getType()->isBuiltin()
                ? $parameter->getType()->getName()
                : null;
            if ($class) {
                if ($this->getRequest()->hasObject($class)) {
                    $argument = $this->getRequest()->getObject($class);
                    if (!$argument instanceof $class) {
                        // если метод миддлвара позволяет параметру быть null
                        if ($parameter->allowsNull()) {
                            $argument = null;
                        } else {
                            throw new MiddlewareException('emptyArgument_' . $parameter->getName());
                        }
                    }
                } else {
                    $containerDependency = $this->getDependency($class);
                    if (false === $containerDependency && !$parameter->allowsNull()) {
                        throw new MiddlewareException('emptyContainerArgument_' . $parameter->getName());
                    }
                    if (false === $containerDependency && $parameter->allowsNull()) {
                        $argument = null;
                    } else {
                        $argument = $containerDependency;
                    }
                }
            }

            $dependencies[] = $argument;
        }

        $response = $this(...$dependencies);

        if ($response instanceof ResponseInterface) {
            return $response;
        } else {
            return $handler->handle($this->getRequest());
        }
    }

    /**
     * @inheritdoc
     */
    final public function getRequest(): RequestDecoratorInterface
    {
        return $this->request;
    }

    /**
     * @param RequestDecoratorInterface $request
     * @return AbstractMiddleware
     */
    private function setRequest(RequestDecoratorInterface $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Should check if the object that implements $className class exist in the Container.
     * If it is, returns it. If not - returns false.
     *
     * @return false|object
     */
    private function getDependency(string $className)
    {
        if ($this->container->has($className)) {
            return $this->container->get($className);
        } else {
            return false;
        }
    }
}