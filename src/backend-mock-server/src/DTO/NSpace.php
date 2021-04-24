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

    public function getSettings(): array
    {
        return $this->settings;
    }

    public function getRequests(): array
    {
        return $this->requests;
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

    public function setSettings(array $settings): NSpace
    {
        $this->settings = $settings;
        return $this;
    }

    public function setRequests(array $requests): NSpace
    {
        $this->requests = $requests;
        return $this;
    }

    public function setName(string $name): NSpace
    {
        $this->name = $name;
        return $this;
    }
}