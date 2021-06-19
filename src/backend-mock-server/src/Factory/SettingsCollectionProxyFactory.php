<?php

declare(strict_types=1);

namespace Factory;

use Core\Mongo\SettingsCollectionProxy;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Config;
use Laminas\ServiceManager\Factory\FactoryInterface;

class SettingsCollectionProxyFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');
        /** @var \MongoDB\Database $mongoDatabase */
        $mongoDatabase = $container->get(\MongoDB\Database::class);

        return new SettingsCollectionProxy(
            $mongoDatabase->selectCollection($config['mongo']['metadata']['collections']['settings'])
        );
    }
}
