<?php

declare(strict_types=1);

namespace Core\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * Class Request
 * @package Core\Middleware
 */
abstract class RequestDecorator implements RequestDecoratorInterface
{
    /**
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * Request constructor.
     * @param ServerRequestInterface $request
     */
    final public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @inheritdoc
     */
    final public function hasObject(string $name): bool
    {
        return $this->hasAttribute($name);
    }

    /**
     * @inheritDoc
     */
    final public function hasAttribute($name): bool
    {
        return array_key_exists($name, $this->getAttributes());
    }

    /**
     * @inheritDoc
     */
    final public function getAttributes()
    {
        return $this->request->getAttributes();
    }

    /**
     * @inheritdoc
     */
    final public function withObject(object $object): ServerRequestInterface
    {
        return $this->withAttribute(get_class($object), $object);
    }

    /**
     * @inheritDoc
     */
    final public function withAttribute($name, $value)
    {
        $this->request = $this->request->withAttribute($name, $value);
        return $this;
    }

    /**
     * @inheritdoc
     */
    final public function getObject(string $name): object
    {
        return $this->getAttribute($name);
    }

    /**
     * @inheritDoc
     */
    final public function getAttribute($name, $default = null)
    {
        return $this->request->getAttribute($name, $default);
    }

    /**
     * @inheritdoc
     */
    final public function getRouteParam($paramName, $defaultValue = null)
    {
        $params = $this->getRouteParams();

        if (array_key_exists($paramName, $params)) {
            return $params[$paramName];
        }

        return $defaultValue;
    }

    /**
     * @inheritdoc
     */
    abstract public function getRouteParams(): array;

    /**
     * @deprecated Use getParam($paramName, $defaultValue = null, bool $withCookie = false) instead.
     * @inheritdoc
     */
    final public function getAllParam($paramName, $defaultValue = null, bool $withCookie = false)
    {
        return $this->getParam($paramName, $defaultValue, $withCookie);
    }

    /**
     * @inheritdoc
     */
    final public function getParam($paramName, $defaultValue = null, bool $withCookie = false)
    {
        $params = $this->getAllParams($withCookie);

        if (array_key_exists($paramName, $params)) {
            return $params[$paramName];
        }

        return $defaultValue;
    }

    /**
     * @inheritdoc
     */
    final public function getAllParams(bool $withCookie = false): array
    {
        $params = array_merge(
            $this->getRouteParams(),
            $this->getParsedBody(),
            $this->getQueryParams()
        );

        if ($withCookie) {
            $params = array_merge($params, $this->getCookieParams());
        }

        return $params;
    }

    /**
     * @inheritDoc
     */
    final public function getParsedBody()
    {
        return $this->request->getParsedBody();
    }

    /**
     * @inheritDoc
     */
    final public function getQueryParams()
    {
        return $this->request->getQueryParams();
    }

    /**
     * @inheritDoc
     */
    final public function getCookieParams()
    {
        return $this->request->getCookieParams();
    }

    /**
     * @inheritdoc
     */
    final public function getOriginalQueryParams(): array
    {
        $result = [];

        $params = array_filter(explode('&', $this->getUri()->getQuery()));

        if (count($params)) {
            array_map(
                function ($value) use (&$result) {
                    list($key, $value) = explode('=', $value);

                    if ($key) {
                        $result[$key] = urldecode($value);
                    }
                },
                $params
            );
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    final public function getUri()
    {
        return $this->request->getUri();
    }

    /**
     * @inheritDoc
     */
    final public function getServerParams()
    {
        return $this->request->getServerParams();
    }

    /**
     * @inheritDoc
     */
    final public function withCookieParams(array $cookies)
    {
        $this->request = $this->request->withCookieParams($cookies);
        return $this;
    }

    /**
     * @inheritDoc
     */
    final public function withQueryParams(array $query)
    {
        $this->request = $this->request->withQueryParams($query);
        return $this;
    }

    /**
     * @inheritDoc
     */
    final public function getUploadedFiles()
    {
        return $this->request->getUploadedFiles();
    }

    /**
     * @inheritDoc
     */
    final public function withUploadedFiles(array $uploadedFiles)
    {
        $this->request = $this->request->withUploadedFiles($uploadedFiles);
        return $this;
    }

    /**
     * @inheritDoc
     */
    final public function withParsedBody($data)
    {
        $this->request = $this->request->withParsedBody($data);
        return $this;
    }

    /**
     * @inheritDoc
     */
    final public function withoutAttribute($name)
    {
        $this->request = $this->request->withoutAttribute($name);
        return $this;
    }

    /**
     * @inheritDoc
     */
    final public function getRequestTarget()
    {
        return $this->request->getRequestTarget();
    }

    /**
     * @inheritDoc
     */
    final public function withRequestTarget($requestTarget)
    {
        $this->request = $this->request->withRequestTarget($requestTarget);
        return $this;
    }

    /**
     * @inheritDoc
     */
    final public function getMethod()
    {
        return $this->request->getMethod();
    }

    /**
     * @inheritDoc
     */
    final public function withMethod($method)
    {
        $this->request = $this->request->withMethod($method);
        return $this;
    }

    /**
     * @inheritDoc
     */
    final public function withUri(UriInterface $uri, $preserveHost = false)
    {
        $this->request = $this->request->withUri($uri, $preserveHost);
        return $this;
    }

    /**
     * @inheritDoc
     */
    final public function getProtocolVersion()
    {
        return $this->request->getProtocolVersion();
    }

    /**
     * @inheritDoc
     */
    final public function withProtocolVersion($version)
    {
        $this->request = $this->request->withProtocolVersion($version);
        return $this;
    }

    /**
     * @inheritDoc
     */
    final public function getHeaders()
    {
        return $this->request->getHeaders();
    }

    /**
     * @inheritDoc
     */
    final public function hasHeader($name)
    {
        return $this->request->hasHeader($name);
    }

    /**
     * @inheritDoc
     */
    final public function getHeader($name)
    {
        return $this->request->getHeader($name);
    }

    /**
     * @inheritDoc
     */
    final public function getHeaderLine($name)
    {
        return $this->request->getHeaderLine($name);
    }

    /**
     * @inheritDoc
     */
    final public function withHeader($name, $value)
    {
        $this->request = $this->request->withHeader($name, $value);
        return $this;
    }

    /**
     * @inheritDoc
     */
    final public function withAddedHeader($name, $value)
    {
        $this->request = $this->request->withAddedHeader($name, $value);
        return $this;
    }

    /**
     * @inheritDoc
     */
    final public function withoutHeader($name)
    {
        $this->request = $this->request->withoutHeader($name);
        return $this;
    }

    /**
     * @inheritDoc
     */
    final public function getBody()
    {
        return $this->request->getBody();
    }

    /**
     * @inheritDoc
     */
    final public function withBody(StreamInterface $body)
    {
        $this->request = $this->request->withBody($body);
        return $this;
    }
}
