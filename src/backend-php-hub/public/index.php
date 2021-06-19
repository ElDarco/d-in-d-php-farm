<?php

declare(strict_types=1);

// Catch throwable before run app
try {
    ini_set('error_reporting', (string) E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');

    // Delegate static file requests back to the PHP built-in webserver
    if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
        return false;
    }

    chdir(dirname(__DIR__));
    require 'vendor/autoload.php';

    /**
     * Self-called anonymous function that creates its own scope and keeps the global namespace clean.
     */
    (function () {
        /** @var \Psr\Container\ContainerInterface $container */
        $container = require 'config/container.php';

        /** @var \Mezzio\Application $app */
        $app = $container->get(\Mezzio\Application::class);
        $factory = $container->get(\Mezzio\MiddlewareFactory::class);

        // Execute programmatic/declarative middleware pipeline and routing
        // configuration statements
        (require 'config/pipeline.php')($app, $factory, $container);
        (require 'config/routes.php')($app, $factory, $container);

        $app->run();
    })();
} catch (\Throwable $e) {
    echo 'Catch error before run app' . PHP_EOL;
    echo 'Message: ' . $e->getMessage() . PHP_EOL;
}
