<?php

namespace Middleware\PhpInstance\UseCase;

use Core\DTO\ResponseData;
use Doctrine\ORM\EntityManager;
use Entity\PhpInstance;
use Exceptions\PhpInstanceNotFound;
use GuzzleHttp\Client;
use Middleware\InvokableMiddleware;

/**
 * Class PhpInstanceRunQuery
 * @package Middleware\PhpInstance\UseCase
 */
class PhpInstanceRunQuery extends InvokableMiddleware
{
    /**
     * @param PhpInstance $phpInstance
     * @param Client $httpClient
     * @param ResponseData $responseData
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function __invoke(
        PhpInstance $phpInstance,
        Client $httpClient,
        ResponseData $responseData
    ) {
        $requestBody = $this->getRequest()->getParsedBody();
        $response = $httpClient->post(
            $phpInstance->publicUrl,
            ['json' =>  $requestBody]
        );

        $responseData->responseFromPhpInstance =
            json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        $responseData->responseCodeFromPhpInstance = $response->getStatusCode();
    }

}