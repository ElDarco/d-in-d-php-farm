<?php

namespace Middleware\PhpInstance\UseCase;

use Core\DTO\ResponseData;
use Doctrine\ORM\EntityManager;
use Entity\Instance;
use Exceptions\PhpInstanceNotFound;
use Middleware\InvokableMiddleware;

/**
 * Class GetActivePhpInstanceByUuid
 * @package Middleware\PhpInstance\UseCase
 */
class GetActivePhpInstanceByUuid extends InvokableMiddleware
{
    /**
     * @param EntityManager $em
     * @throws \ReflectionException
     */
    public function __invoke(
        EntityManager $em
    ) {
        $phpInstanceUUID = $this->getRequest()->getAttribute('instanceUUID');

        /** @var Instance $phpInstance */
        $phpInstance = $em->getRepository(Instance::class)->findOneBy([
            'uuid' => $phpInstanceUUID
        ]);

        if (!$phpInstance instanceof Instance) {
            throw PhpInstanceNotFound::create();
        }

        $this->getRequest()->withObject($phpInstance);
    }

}
