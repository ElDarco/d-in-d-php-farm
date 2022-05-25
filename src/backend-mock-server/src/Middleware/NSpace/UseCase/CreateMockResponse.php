<?php

namespace Middleware\NSpace\UseCase;

use Core\Middleware\RequestDecoratorInterface;
use DTO\NRequest;
use DTO\NSettings;
use DTO\NSpace;
use Factory\DtoFactory;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\RequestOptions;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\EmptyResponse;
use Middleware\InvokableMiddleware;
use Psr\Http\Message\ResponseInterface;
use function is_array;
use function is_string;
use function str_contains;

class CreateMockResponse extends InvokableMiddleware
{
    public function __invoke(
        NSpace $nSpace,
        NRequest $nRequest,
        NSettings $nSettings = null
    ) {
        $speedResponseMs = $nSpace->getSpeedResponseMS();
        if ($speedResponseMs > 0) {
          usleep($speedResponseMs);
        }

        if ($nSettings) {
            $bodyRaw = $nSettings->getResponseBody();
            $response = new Response();
            $response->getBody()->write($bodyRaw);
            $response = $response->withStatus($nSettings->getResponseCode());
            foreach ($nSettings->getHeaders() as $headerKey => $headerValue) {
                $response = $response->withHeader($headerKey, $headerValue);
            }
        } elseif ($nSpace->isUseProxy()) {
            $proxyUri = new Uri($nSpace->getProxyToUrl());

            $uri = $this->getRequest()->getUri()
                ->withHost($proxyUri->getHost())
                ->withScheme($proxyUri->getScheme())
                ->withPort($proxyUri->getPort())
                ->withPath($nRequest->getUri()); // TODO: тут можно комбинировать с прокси path
            
            $request = $this->getRequest();
            $request = $request->withUri($uri);

            $client = new Client(['http_errors' => false]);
            $response = $client->send($request, $this->prepareOptions($request));
// TODO Нет заголовков на http://localhost:18081/mock-server/n/d73039c5-647a-447e-be83-9ae917b1574b/123 https://google.com
// TODO Ошибка ответа http://localhost:18081/mock-server/n/d73039c5-647a-447e-be83-9ae917b1574b/search?q=123 https://google.com
            $nProxyResponse = DtoFactory::createNProxyResponse($response->getBody()->getContents(), $response->getStatusCode(), $response->getHeaders());
            $nRequest->addNProxyResponse($nProxyResponse);

            $response->getBody()->rewind();
            $this->getRequest()->withAttribute(NRequest::class, $nRequest);
        } else {
            $response = new EmptyResponse(418);
        }

        $this->getRequest()->withAttribute(ResponseInterface::class, $response);
    }

    private function prepareOptions(RequestDecoratorInterface $request): array
    {
        $options = [];

        if (str_contains($request->getHeader('content-type')[0] ?? '', 'multipart/form-data')) {
            $request->withoutHeader('content-type');
            $options[RequestOptions::MULTIPART] = $this->transformMultipart($request->getParsedBody());
        }

        return $options;
    }

    private function transformMultipart(object|array|null $parsedBody): array
    {
        $result = [];

        if (is_array($parsedBody)) {
            // TODO: Добавить поддержку файлов 'contents' => Psr7\Utils::tryFopen('/path/to/file', 'r'),
            // https://docs.guzzlephp.org/en/stable/request-options.html#multipart
            foreach ($parsedBody as $fieldName => $fieldValue) {
                if (is_string($fieldValue)) {
                    $result[] = [
                        'name' => $fieldName,
                        'contents' => $fieldValue,
                    ];
                }
            }
        }

        return $result;
    }
}