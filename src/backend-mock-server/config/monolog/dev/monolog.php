<?php

return [
    'monolog' => [
        'app' => [
            'path' => __DIR__ . '/../../../logs/app.log',
            'level' => \Psr\Log\LogLevel::DEBUG,
        ]
    ]
];
