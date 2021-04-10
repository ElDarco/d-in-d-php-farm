<?php

namespace Sandbox;

use Entity\Instance;
use GuzzleHttp\Client;

class SandboxFactory
{
    /**
     * @var Client
     */
    private Client $httpClient;

    public function __construct(Client $httpClient)
    {

        $this->httpClient = $httpClient;
    }

    public function createByInstance(Instance $instance): SandboxInterface
    {
        switch ($instance->lang) {
            case "php": {
                return new PhpSandbox($this->httpClient, $instance->publicUrl);
            }
        }

        return new \DomainException("cant found lang");
    }

}
