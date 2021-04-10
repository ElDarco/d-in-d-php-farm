<?php

namespace Middleware\PhpInstance\UseCase;

use Core\DTO\ResponseData;
use Entity\Instance;
use GuzzleHttp\Client;
use Middleware\InvokableMiddleware;
use Sandbox\SandboxFactory;

/**
 * Class PhpInstanceRunQuery
 * @package Middleware\PhpInstance\UseCase
 */
class InstanceRunQuery extends InvokableMiddleware
{
    /**
     * @param Instance $phpInstance
     * @param Client $httpClient
     * @param ResponseData $responseData
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function __invoke(
        Instance $phpInstance,
        Client $httpClient,
        ResponseData $responseData
    ) {
        $requestBody = $this->getRequest()->getParsedBody();

        $sandboxFactory = new SandboxFactory($httpClient);
        $sandbox = $sandboxFactory->createByInstance($phpInstance);

        $sandboxResponse = $sandbox->run($requestBody, $requestBody['profiler'] ?? false);


        $responseData->responseFromPhpInstance = $sandboxResponse->getOutput();
        $responseData->responseCodeFromPhpInstance = $sandboxResponse->getResponseStatus();

        if (!empty($sandboxResponse->getProfilerResult()['responseDebugGUIUrl'])) {
            $responseData->responseDebugGUIUrl = $sandboxResponse->getProfilerResult()['responseDebugGUIUrl'];
        }
    }

}
