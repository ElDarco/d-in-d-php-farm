<?php

namespace Sandbox;

class SandboxResult
{
    private int $responseStatus;
    private string $output;
    private array $profilerResult;

    public function __construct(int $responseStatus, string $output, array $profilerResult)
    {
        $this->responseStatus = $responseStatus;
        $this->output = $output;
        $this->profilerResult = $profilerResult;
    }

    /**
     * @return int
     */
    public function getResponseStatus(): int
    {
        return $this->responseStatus;
    }

    /**
     * @return string
     */
    public function getOutput(): string
    {
        return $this->output;
    }

    /**
     * @return array
     */
    public function getProfilerResult(): array
    {
        return $this->profilerResult;
    }

}
