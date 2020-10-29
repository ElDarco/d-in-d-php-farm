<?php

declare(strict_types=1);

$_ENV['APP_DB_HOST']     = $_ENV['APP_DB_HOST']     ?? null;
$_ENV['APP_DB_PORT']     = $_ENV['APP_DB_PORT']     ?? 3306;
$_ENV['APP_DB_USER']     = $_ENV['APP_DB_USER']     ?? null;
$_ENV['APP_DB_PASSWORD'] = $_ENV['APP_DB_PASSWORD'] ?? '';
$_ENV['APP_DB_DATABASE'] = $_ENV['APP_DB_DATABASE'] ?? null;

if (empty($_ENV['APP_DB_HOST']) || empty($_ENV['APP_DB_USER']) || empty($_ENV['APP_DB_DATABASE'])) {
    throw new \Doctrine\DBAL\ConnectionException('Incorrect database connection configuration');
}

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driver_class' => \Doctrine\DBAL\Driver\PDOMySql\Driver::class,
                'params' => [
                    'host'     => $_ENV['APP_DB_HOST'],
                    'port'     => $_ENV['APP_DB_PORT'],
                    'user'     => $_ENV['APP_DB_USER'] ?? '',
                    'password' => $_ENV['APP_DB_PASSWORD'] ?? '',
                    'dbname'   => $_ENV['APP_DB_DATABASE'] ?? '',
                    'driverOptions' => [
                        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                    ],
                    'server_version' => '5.7'

                ],
            ],
        ],
        'driver' => [
            'orm_default' => [
                'class' => \Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain::class,
                'drivers' => [
                    'Entity' => 'my_entity',
                ],
            ],
            'my_entity' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => __DIR__ . '/../../src/Entity',
            ],
        ],
        'configuration' => [
            'orm_default' => [
                'metadata_cache'    => 'filesystem',
                'query_cache'       => 'filesystem',
                'result_cache'      => 'filesystem',
            ]
        ],
        'migrations' => [
            'directory' => 'migrations',
            'name' => 'My DB Migrations',
            'namespace' => 'DoctrineMigrations',
            'table' => 'migration',
            'column' => 'version_timestamp',
        ],
    ],
    'dependencies' => [
    ],
];