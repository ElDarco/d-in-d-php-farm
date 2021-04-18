<?php

declare(strict_types=1);

return [
    // Provides application-wide services.
    // We recommend using fully-qualified class names whenever possible as
    // service names.
    'dependencies' => [
        'abstract_factories' => [
            \Factory\MiddlewareFactory::class,
        ],
        // Use 'aliases' to alias a service name to another service. The
        // key is the alias name, the value is the service to which it points.
        'aliases' => [
            // Fully\Qualified\ClassOrInterfaceName::class => Fully\Qualified\ClassName::class,
        ],
        // Use 'invokables' for constructor-less services, or services that do
        // not require arguments to the constructor. Map a service name to the
        // class name.
        'invokables' => [
            // Fully\Qualified\InterfaceName::class => Fully\Qualified\ClassName::class,
        ],
        // Use 'factories' for services provided by callbacks/factory classes.
        'factories'  => [
            \MongoDB\Client::class  => \Factory\MongoFactory::class,
            \MongoDB\Database::class  => \Factory\MongoDatabaseFactory::class,
            \Core\Mongo\SettingsCollectionProxy::class => \Factory\SettingsCollectionProxyFactory::class,
            // Fully\Qualified\ClassName::class => Fully\Qualified\FactoryName::class,
            \GuzzleHttp\Client::class => \Factory\GuzzleFactory::class,
            \Mezzio\ProblemDetails\ProblemDetailsMiddleware::class => \Mezzio\ProblemDetails\ProblemDetailsMiddlewareFactory::class,
        ],
    ],
];
