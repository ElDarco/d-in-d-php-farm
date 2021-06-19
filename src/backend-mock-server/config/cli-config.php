<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\MetadataFilter;
use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

try {
    $container = require 'container.php';

    // Fetch the entity Manager
    /** @var \Doctrine\ORM\EntityManager $entityManager */
    $entityManager = $container->get(\Doctrine\ORM\EntityManager::class);

    // Create the helperset
    $helperSet = ConsoleRunner::createHelperSet($entityManager);
    $helperSet->set(new \Symfony\Component\Console\Helper\QuestionHelper(), 'dialog');

    /**
     * @var \Doctrine\ORM\EntityManager $entityManager
     */

    $isDevMode = true;

    /** Migrations setup */
    $configuration = new \Doctrine\Migrations\Configuration\Configuration($entityManager->getConnection());
    $configuration->setMigrationsDirectory('migrations');
    $configuration->setMigrationsNamespace('DoctrineMigrations');

    $diff = new \Doctrine\Migrations\Tools\Console\Command\DiffCommand();
    $exec = new \Doctrine\Migrations\Tools\Console\Command\ExecuteCommand();
    $gen = new \Doctrine\Migrations\Tools\Console\Command\GenerateCommand();
    $migrate = new \Doctrine\Migrations\Tools\Console\Command\MigrateCommand();
    $status = new \Doctrine\Migrations\Tools\Console\Command\StatusCommand();
    $ver = new \Doctrine\Migrations\Tools\Console\Command\VersionCommand();

    $diff->setMigrationConfiguration($configuration);
    $gen->setMigrationConfiguration($configuration);
    $exec->setMigrationConfiguration($configuration);
    $migrate->setMigrationConfiguration($configuration);
    $status->setMigrationConfiguration($configuration);
    $ver->setMigrationConfiguration($configuration);


    $cli = ConsoleRunner::createApplication($helperSet, [
        $diff, $exec, $gen, $migrate, $status, $ver
    ]);

    return $cli->run();
} catch (\Throwable $e) {
    echo 'Catch error before run app' . PHP_EOL;
    echo 'Message: ' . $e->getMessage() . PHP_EOL;
}
