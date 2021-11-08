<?php

declare(strict_types=1);

namespace DTO;

use Core\TurnoverObject\TurnoverObject;

class NSpace extends TurnoverObject
{
    public function __construct(
        protected string $id,
        protected string $name,
        protected array $settings = [],
        protected array $requests = [],
        protected bool $useProxy = false,
        protected string $proxyToUrl = '',
        protected int $speedResponseMS = 0
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getSettingsObjects(): array
    {
        return $this->settings;
    }

    public function getRequestsObjects(): array
    {
        return $this->requests;
    }

    public function getSettings(): array
    {
        $settingsArray = [];
        foreach ($this->settings as $setting) {
            if ($setting instanceof NSettings)
                $settingsArray[] = $setting->toArray();
        }
        return $settingsArray;
    }

    public function getRequests(): array
    {
        $requestArray = [];
        foreach ($this->requests as $request) {
            if ($request instanceof NRequest)
                $requestArray[] = $request->toArray();
        }
        return $requestArray;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isUseProxy(): bool
    {
        return $this->useProxy;
    }

    public function getProxyToUrl(): string
    {
        return $this->proxyToUrl;
    }

    public function setId(string $id): NSpace
    {
        $this->id = $id;
        return $this;
    }

    public function addSettings(NSettings $nSettings): NSpace
    {
        $this->settings[] = $nSettings;
        return $this;
    }

    public function addRequests(NRequest $nRequest): NSpace
    {
        $this->requests[] = $nRequest;
        return $this;
    }

    public function sliceRequests(): array
    {
        $this->requests = array_slice($this->requests, -20, 20);
        return $this->requests;
    }

    public function setName(string $name): NSpace
    {
        $this->name = $name;
        return $this;
    }

    public function setUseProxy(bool $useProxy): NSpace
    {
        $this->useProxy = $useProxy;
        return $this;
    }

    public function setProxyToUrl(string $proxyToUrl): NSpace
    {
        $this->proxyToUrl = $proxyToUrl;
        return $this;
    }

    public function getSpeedResponseMS(): int
    {
        return $this->speedResponseMS;
    }

    public function setSpeedResponseMS(int $speedResponseMS): NSpace
    {
        $this->speedResponseMS = $speedResponseMS;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'settings' => $this->getSettings(),
            'requests' => $this->getRequests(),
            'useProxy' => $this->isUseProxy(),
            'proxyToUrl' => $this->getProxyToUrl(),
            'speedResponseMS' => $this->getSpeedResponseMS(),
        ];
    }
}