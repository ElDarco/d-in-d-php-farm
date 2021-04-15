<?php

declare(strict_types=1);

namespace Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Config;
use Laminas\ServiceManager\Factory\FactoryInterface;

class MongoDatabaseFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get(Config::class);
        $mongoClient = $container->get(\MongoDB\Client::class);
        return $mongoClient->selectDatabase($config->metadata->database);
    }
}
