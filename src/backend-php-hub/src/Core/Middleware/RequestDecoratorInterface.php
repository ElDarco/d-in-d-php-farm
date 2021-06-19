<?php

declare(strict_types=1);

namespace Core\Middleware;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Interface RequestInterface
 * @package Core\Middleware
 */
interface RequestDecoratorInterface extends ServerRequestInterface
{
    /**
     * RequestInterface constructor.
     * @param ServerRequestInterface $request
     */
    public function __construct(ServerRequestInterface $request);

    /**
     * Checks if object exist in the request.
     *
     * @param string $name
     * @return bool
     */
    public function hasObject(string $name): bool;

    /**
     * Stores the object in request.
     *
     * @param object $object
     * @return ServerRequestInterface
     */
    public function withObject(object $object): ServerRequestInterface;

    /**
     * Returns the object that is stored in request.
     *
     * @param string $name Class or interface name
     * @return object
     */
    public function getObject(string $name): object;

    /**
     * Gets route params (route tokens from URI) as array.
     *
     * @return array
     */
    public function getRouteParams(): array;

    /**
     * Gets route param value by token name.
     *
     * @param $paramName
     * @param null $defaultValue
     * @return mixed|null
     */
    public function getRouteParam($paramName, $defaultValue = null);

    /**
     * Gets all params: from query string, from request body, from route.
     *
     * @param bool $withCookie If true the $_COOKIE array will be also used
     * @return array
     */
    public function getAllParams(bool $withCookie = false): array;

    /**
     * Checks if the $paramName exist in any of input param scopes (query string, request body, route) and
     * returns it.
     *
     * @param $paramName
     * @param null $defaultValue
     * @param bool $withCookie If true the $_COOKIE array will be also used
     * @return mixed|null
     * @deprecated Use getParam($paramName, $defaultValue = null, bool $withCookie = false) instead.
     */
    public function getAllParam($paramName, $defaultValue = null, bool $withCookie = false);

    /**
     * Checks if the $paramName exist in any of input param scopes (query string, request body, route) and
     * returns it.
     *
     * @param $paramName
     * @param null $defaultValue
     * @param bool $withCookie If true the $_COOKIE array will be also used
     * @return mixed|null
     */
    public function getParam($paramName, $defaultValue = null, bool $withCookie = false);

    /**
     * $request->getQueryParams преобразует параметры по каким-то своим законам,
     * иногда нужно получать оригинальные, нетронутые параметры GET запроса.
     *
     * @return array params
     */
    public function getOriginalQueryParams(): array;
}