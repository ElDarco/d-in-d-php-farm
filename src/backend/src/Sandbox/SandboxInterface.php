<?php

namespace Sandbox;

interface SandboxInterface
{
    public function run(string $code, bool $withProfiler): SandboxResult;
}
