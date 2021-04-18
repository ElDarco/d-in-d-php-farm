<?php

namespace Middleware\PhpInstance\UseCase;

use Core\DTO\ResponseData;
use Doctrine\ORM\EntityManager;
use Entity\PhpInstance;
use Exceptions\NamespaceNotFound;
use Exceptions\ServerErrorExceptions\PhpInstanceBroken;
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
     * @throws \JsonException
     */
    public function __invoke(
        PhpInstance $phpInstance,
        Client $httpClient,
        ResponseData $responseData
    ) {
        $requestBody = $this->getRequest()->getParsedBody();

        $response = $httpClient->post(
            $phpInstance->publicUrl,
            [
                'json' =>  $requestBody
            ]
        );

        if ($response->getBody()->getContents() === '') {
            throw PhpInstanceBroken::create();
        }
        $response->getBody()->rewind();

        $responseData->responseFromPhpInstance =
            json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        $response->getBody()->rewind();

        $responseData->responseCodeFromPhpInstance = $response->getStatusCode();

        if (array_key_exists('profiler', $requestBody) && $requestBody['profiler']) {
            //Мне больно от такой интеграции. Простите
            $XHPROF_ROOT = '/var/www';
            include_once $XHPROF_ROOT . "/profiler/xhprof_lib/utils/xhprof_lib.php";
            include_once $XHPROF_ROOT . "/profiler/xhprof_lib/utils/xhprof_runs.php";
            $xhprof_runs = new \XHProfRuns_Default();

            $result = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
            $xhprofData = $result['profiler'];

            $key = time();
            $run_id = $xhprof_runs->save_run($xhprofData, $key);
            $responseData->responseDebugGUIUrl = '/profiler/xhprof_html/?run=' . $run_id . '&source=' . $key;
        }
    }

}