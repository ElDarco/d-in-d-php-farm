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
        protected array $requests = []
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

    public function setName(string $name): NSpace
    {
        $this->name = $name;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'settings' => $this->getSettings(),
            'requests' => $this->getRequests(),
        ];
    }
}