<?php

declare(strict_types=1);

namespace Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Config;
use Laminas\ServiceManager\Factory\FactoryInterface;

class SettingsCollectionFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get(Config::class);
        $mongoDatabase = $container->get(\MongoDB\Database::class);

        return $mongoDatabase->selectCollection($config->metadata->collections->settings);
    }
}
