<?php

declare(strict_types=1);

namespace Core\Mongo;

class SettingsCollectionProxy
{
    public function __construct(public \MongoDB\Collection $collection) {}
}