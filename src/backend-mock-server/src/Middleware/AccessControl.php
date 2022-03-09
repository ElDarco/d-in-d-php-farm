<?php

declare(strict_types=1);

namespace Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AccessControl implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $response = $handler->handle($request)
            ->withHeader('Access-Control-Max-Age', '86400')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, HEAD, OPTIONS')
            ->withHeader(
                'Access-Control-Allow-Headers',
                'Content-Type, Access-Control-Allow-Headers, X-Requested-With,'
                . ' Authorization, Refresh-token, Ha-city-slug, Ha-Fias-Uuid, Pragma'
            );

        if (
            !array_key_exists('APP_MOCK_ACCESS_CONTROL_ALLOW_ORIGIN', $_ENV)
            || !$_ENV['APP_MOCK_ACCESS_CONTROL_ALLOW_ORIGIN']
            || $_ENV['APP_MOCK_ACCESS_CONTROL_ALLOW_ORIGIN'] === '*'
        ) {
            $origin = $request->getHeader('Origin');
            if (is_string(current($origin))) {
                $origin = current($origin);
            } else {
                $origin = '*';
            }

            return $response
                ->withHeader('Access-Control-Allow-Credentials', 'true')
                ->withHeader('Access-Control-Allow-Origin', $origin);
        }

        $allowedOrigins = explode(",", $_ENV['APP_MOCK_ACCESS_CONTROL_ALLOW_ORIGIN'] ?? '');
        $requestOrigin  = $request->getHeaderLine('Origin');

        if (!empty($allowedOrigins)) {
            foreach ($allowedOrigins as $allowedOrigin) {
                $allowedOrigin = trim($allowedOrigin);

                if (!empty($allowedOrigin) && $allowedOrigin === $requestOrigin) {
                    $response = $response
                        ->withHeader('Access-Control-Allow-Origin', $allowedOrigin)
                        ->withHeader('Access-Control-Allow-Credentials', 'true');

                    break;
                }
            }
        }

        return $response;
    }
}
