<?php

declare(strict_types=1);

namespace Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Config;
use Laminas\ServiceManager\Factory\FactoryInterface;

class MongoFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');

        return new \MongoDB\Client('mongodb://' . $config['mongo']['host'] . '/?maxIdleTimeMS=60000', [
            'username' => $config['mongo']['username'],
            'password' => $config['mongo']['password'],
        ]);
    }
}
