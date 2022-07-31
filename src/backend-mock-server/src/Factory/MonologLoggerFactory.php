<?php

declare(strict_types=1);

namespace Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\PsrLogMessageProcessor;

class MonologLoggerFactory implements FactoryInterface
{
    private const LOG_NAME = 'app';

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');
        $logConfig = $config['monolog'][self::LOG_NAME];

        $logger = new Logger(self::LOG_NAME);
        $logger->pushHandler(new StreamHandler(
            $logConfig['path'],
            $logConfig['level']
        ));
        $logger->pushProcessor(new PsrLogMessageProcessor());

        return $logger;
    }
}
