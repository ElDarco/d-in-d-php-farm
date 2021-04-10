<?php

namespace Sandbox;

use Exceptions\ServerErrorExceptions\PhpInstanceBroken;
use GuzzleHttp\Client;

class PhpSandbox implements SandboxInterface
{

    /**
     * @var Client
     */
    private Client $httpClient;
    private string $publicUrl;

    public function __construct(Client $httpClient, string $publicUrl)
    {

        $this->httpClient = $httpClient;
        $this->publicUrl = $publicUrl;
    }


    public function run(string $code, bool $withProfiler): SandboxResult
    {
        if ($code === '') {
            throw PhpInstanceBroken::create();
        }

        $response = $this->httpClient->post(
            $this->publicUrl,
            [
                'json' => $code,
            ]
        );

        if ($response->getBody()->getContents() === '') {
            throw PhpInstanceBroken::create();
        }
        $response->getBody()->rewind();

        $answer =
            json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        $response->getBody()->rewind();

        if ($withProfiler) {
            //Мне больно от такой интеграции. Простите
            $XHPROF_ROOT = '/var/www';
            include_once $XHPROF_ROOT . "/profiler/xhprof_lib/utils/xhprof_lib.php";
            include_once $XHPROF_ROOT . "/profiler/xhprof_lib/utils/xhprof_runs.php";
            $xhprof_runs = new \XHProfRuns_Default();

            $result = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
            $xhprofData = $result['profiler'];

            $key = time();
            $run_id = $xhprof_runs->save_run($xhprofData, $key);
            $responseDebugGUIUrl = '/profiler/xhprof_html/?run=' . $run_id . '&source=' . $key;
        }


        return new SandboxResult(
            $answer["responseCode"],
            $answer["result"],
            [
                "responseDebugGUIUrl" => $responseDebugGUIUrl,
            ]
        );
    }
}
