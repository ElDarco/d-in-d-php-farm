<?php
declare(strict_types=1);

return [
    'mongo' => [
        'host'       => $_ENV['APP_MONGODB_HOST'] ?? 'mongo',
        'username'   => $_ENV['APP_MONGODB_USER'] ?? null,
        'password'   => $_ENV['APP_MONGODB_PASSWORD'] ?? null,

        'metadata'   => [
            'database' => $_ENV['APP_MONGODB_DATABASE'] ?? 'database',
            'collections' => [
                'settings' => 'settings'
            ]
        ],
    ],
];

