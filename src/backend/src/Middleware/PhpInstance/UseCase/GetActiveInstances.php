<?php

namespace Middleware\PhpInstance\UseCase;

use Core\DTO\ResponseData;
use Doctrine\ORM\EntityManager;
use Entity\Instance;
use Middleware\InvokableMiddleware;

/**
 * Class GetActivePhpInstance
 * @package Middleware\PhpInstance\UseCase
 */
class GetActiveInstances extends InvokableMiddleware
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
        /** @var Instance[] $phpInstances */
        $phpInstances = $em->getRepository(Instance::class)->findBy([
            'status' => Instance::STATUS_ACTIVE,
        ], [
            'phpVersion' => 'DESC',
        ]);

        $phpInstancesResponseData = [];
        foreach ($phpInstances as $phpInstance) {
            $phpInstancesResponseData[] = $phpInstance->export([], ['uuid', 'lang', 'version', 'status', 'runUrl', 'shortVersion']);
        }

        $responseData->phpInstances = $phpInstancesResponseData;
    }

}
