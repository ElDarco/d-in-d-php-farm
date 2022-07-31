<?php

return [
    'monolog' => [
        'app' => [
            'path' => 'php://stdout',
            'level' => \Psr\Log\LogLevel::WARNING,
        ]
    ]
];
