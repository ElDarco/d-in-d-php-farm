<?php

declare(strict_types=1);

namespace DTO;

use Core\TurnoverObject\TurnoverObject;

class NSpace extends TurnoverObject
{
    public function __construct(
        protected string $id,
        protected string $name,
        protected array $settings = []
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getSettings(): array
    {
        return $this->settings;
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

    public function setName(string $name): NSpace
    {
        $this->name = $name;
        return $this;
    }
}