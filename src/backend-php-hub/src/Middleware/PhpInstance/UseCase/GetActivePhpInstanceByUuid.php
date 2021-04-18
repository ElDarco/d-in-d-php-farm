<?php

namespace Middleware\PhpInstance\UseCase;

use Core\DTO\ResponseData;
use Doctrine\ORM\EntityManager;
use Entity\PhpInstance;
use Exceptions\NamespaceNotFound;
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
        $phpInstanceUUID = $this->getRequest()->getAttribute('PhpInstanceUUID');

        /** @var PhpInstance $phpInstance */
        $phpInstance = $em->getRepository(PhpInstance::class)->findOneBy([
            'uuid' => $phpInstanceUUID
        ]);

        if (!$phpInstance instanceof PhpInstance) {
            throw NamespaceNotFound::create();
        }

        $this->getRequest()->withObject($phpInstance);
    }

}