<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\MetadataFilter;
use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

$container = require 'container.php';

// Fetch the entity Manager
$entityManager = $container->get(\Doctrine\ORM\EntityManager::class);
// Create the helperset
$helperSet = ConsoleRunner::createHelperSet($entityManager);
$helperSet->set(new \Symfony\Component\Console\Helper\QuestionHelper(), 'dialog');

/**
 * @var \Doctrine\ORM\EntityManager $entityManager
 */

$isDevMode = true;
//$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode, null, null, false);

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

$cli->add(
    new class extends \Doctrine\ORM\Tools\Console\Command\GenerateEntitiesCommand {
        /**
         * {@inheritdoc}
         */
        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $em = $this->getHelper('em')->getEntityManager();

            $cmf = new DisconnectedClassMetadataFactory();
            $cmf->setEntityManager($em);
            $metadatas = $cmf->getAllMetadata();
            $metadatas = MetadataFilter::filter($metadatas, $input->getOption('filter'));

            // Process destination directory
            $destPath = realpath($input->getArgument('dest-path'));

            if (! file_exists($destPath)) {
                throw new \InvalidArgumentException(
                    sprintf("Entities destination directory '<info>%s</info>' does not exist.", $input->getArgument('dest-path'))
                );
            }

            if (! is_writable($destPath)) {
                throw new \InvalidArgumentException(
                    sprintf("Entities destination directory '<info>%s</info>' does not have write permissions.", $destPath)
                );
            }

            if (count($metadatas)) {
                // Create EntityGenerator
                $entityGenerator = new \Doctrine\ORM\Tools\EntityGenerator();

                $entityGenerator->setGenerateAnnotations($input->getOption('generate-annotations'));
                $entityGenerator->setGenerateStubMethods($input->getOption('generate-methods'));
                $entityGenerator->setRegenerateEntityIfExists($input->getOption('regenerate-entities'));
                $entityGenerator->setUpdateEntityIfExists($input->getOption('update-entities'));
                $entityGenerator->setNumSpaces($input->getOption('num-spaces'));
                $entityGenerator->setBackupExisting(!$input->getOption('no-backup'));

                // --
                // @see #9, injected (pan)
                $entityGenerator->setFieldVisibility($entityGenerator::FIELD_VISIBLE_PROTECTED);
                // --

                if (($extend = $input->getOption('extend')) !== null) {
                    $entityGenerator->setClassToExtend($extend);
                }

                foreach ($metadatas as $metadata) {
                    $output->writeln(
                        sprintf('Processing entity "<info>%s</info>"', $metadata->name)
                    );
                }

                // Generating Entities
                $entityGenerator->generate($metadatas, $destPath);

                // Outputting information message
                $output->writeln(PHP_EOL . sprintf('Entity classes generated to "<info>%s</INFO>"', $destPath));
            } else {
                $output->writeln('No Metadata Classes to process.');
            }
        }
    }
);

$cli->add(
    new class extends \Doctrine\ORM\Tools\Console\Command\ConvertMappingCommand {
        /**
         * {@inheritdoc}
         */
        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $em = $this->getHelper('em')->getEntityManager();

            if ($input->getOption('from-database') === true) {
                $databaseDriver = new \Doctrine\ORM\Mapping\Driver\DatabaseDriver(
                    $em->getConnection()->getSchemaManager()
                );

                $em->getConfiguration()->setMetadataDriverImpl(
                    $databaseDriver
                );

                if (($namespace = $input->getOption('namespace')) !== null) {
                    $databaseDriver->setNamespace($namespace);
                }
            }

            $cmf = new DisconnectedClassMetadataFactory();
            $cmf->setEntityManager($em);
            $metadata = $cmf->getAllMetadata();
            $metadata = MetadataFilter::filter($metadata, $input->getOption('filter'));

            // Process destination directory
            if (! is_dir($destPath = $input->getArgument('dest-path'))) {
                mkdir($destPath, 0775, true);
            }
            $destPath = realpath($destPath);

            if (! file_exists($destPath)) {
                throw new \InvalidArgumentException(
                    sprintf("Mapping destination directory '<info>%s</info>' does not exist.", $input->getArgument('dest-path'))
                );
            }

            if (! is_writable($destPath)) {
                throw new \InvalidArgumentException(
                    sprintf("Mapping destination directory '<info>%s</info>' does not have write permissions.", $destPath)
                );
            }

            $toType = strtolower($input->getArgument('to-type'));

            $exporter = $this->getExporter($toType, $destPath);
            $exporter->setOverwriteExistingFiles($input->getOption('force'));

            if ($toType == 'annotation') {
                $entityGenerator = new \Doctrine\ORM\Tools\EntityGenerator();

                // --
                // @see #9, injected (pan)
                $entityGenerator->setFieldVisibility($entityGenerator::FIELD_VISIBLE_PROTECTED);
                // --

                $exporter->setEntityGenerator($entityGenerator);

                $entityGenerator->setNumSpaces($input->getOption('num-spaces'));

                if (($extend = $input->getOption('extend')) !== null) {
                    $entityGenerator->setClassToExtend($extend);
                }
            }

            if (count($metadata)) {
                foreach ($metadata as $class) {
                    $output->writeln(sprintf('Processing entity "<info>%s</info>"', $class->name));
                }

                $exporter->setMetadata($metadata);
                $exporter->export();

                $output->writeln(PHP_EOL . sprintf(
                        'Exporting "<info>%s</info>" mapping information to "<info>%s</info>"',
                        $toType,
                        $destPath
                    ));
            } else {
                $output->writeln('No Metadata Classes to process.');
            }
        }
    }
);

return $cli->run();
