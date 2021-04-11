<?php

namespace Middleware\PhpInstance\UseCase;

use Doctrine\ORM\EntityManager;
use Entity\PhpInstance;
use Exceptions\BadRequestException;
use Exceptions\UnprocessableEntityExceptions\PhpInstanceAlreadyRegistered;
use Middleware\InvokableMiddleware;

/**
 * Class LeaveMarkAboutWork
 * @package Middleware\PhpInstance\UseCase
 */
class LeaveMarkAboutWork extends InvokableMiddleware
{
    /**
     * @param EntityManager $em
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke(
        EntityManager $em
    ) {
        $params = $this->getRequest()->getParsedBody();

        $publicUrl = '';
        if (array_key_exists('publicUrl', $params)) {
            $publicUrl = $params['publicUrl'];
        }

        $phpVersion = '';
        if (array_key_exists('phpVersion', $params)) {
            $phpVersion = $params['phpVersion'];
        }

        if (!$phpVersion) {
            throw BadRequestException::create([
                'phpVersion' => [
                    'isEmpty'
                ]
            ]);
        }

        if (!$publicUrl) {
            throw BadRequestException::create([
                'publicUrl' => [
                    'isEmpty'
                ],
            ]);
        }

        $phpInstance = $em->getRepository(PhpInstance::class)->findOneBy([
            'phpVersion' => $phpVersion,
            'publicUrl' => $publicUrl,
        ]);

        if (!$phpInstance instanceof PhpInstance) {
            $phpInstance = new PhpInstance();
        } else {
            throw PhpInstanceAlreadyRegistered::create();
        }

        $phpInstance->import([
            'phpVersion' => $phpVersion,
            'publicUrl' => $publicUrl,
            'status' => PhpInstance::STATUS_ACTIVE
        ]);

        $em->persist($phpInstance);
        $em->flush($phpInstance);
    }

}