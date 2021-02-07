<?php

namespace Middleware\PhpInstance\UseCase;

use Core\DTO\ResponseData;
use Doctrine\ORM\EntityManager;
use Entity\PhpInstance;
use Middleware\InvokableMiddleware;

/**
 * Class GetActivePhpInstance
 * @package Middleware\PhpInstance\UseCase
 */
class GetActivePhpInstances extends InvokableMiddleware
{
    /**
     * @param EntityManager $em
     * @param ResponseData $responseData
     * @throws \ReflectionException
     */
    public function __invoke(
        EntityManager $em,
        ResponseData $responseData
    ) {
        /** @var PhpInstance[] $phpInstances */
        $phpInstances = $em->getRepository(PhpInstance::class)->findBy([
            'status' => PhpInstance::STATUS_ACTIVE
        ], [
            'phpVersion' => 'DESC'
        ]);

        $phpInstancesResponseData = [];
        foreach ($phpInstances as $phpInstance) {
            $phpInstancesResponseData[] = $phpInstance->export([], ['uuid', 'phpVersion', 'status', 'runUrl']);
        }

        $responseData->phpInstances = $phpInstancesResponseData;
    }

}