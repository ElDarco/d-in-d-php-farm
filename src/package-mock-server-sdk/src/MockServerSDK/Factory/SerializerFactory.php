<?php

declare(strict_types=1);

namespace CodeTry\MockServerSDK\Factory;

use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;

class SerializerFactory
{
    public function createSerializer(): SerializerInterface
    {
        return SerializerBuilder::create()
            ->addDefaultHandlers()
            ->addDefaultListeners()
            ->build();
    }
}
