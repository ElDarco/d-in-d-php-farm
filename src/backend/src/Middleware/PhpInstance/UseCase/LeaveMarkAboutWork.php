<?php

namespace Middleware\PhpInstance\UseCase;

use Doctrine\ORM\EntityManager;
use Entity\Instance;
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

        $publicUrl = $params['publicUrl'] ?? "";
        $version = $params['version'] ?? "";
        $lang = $params['lang'] ?? "";

        if (!$version) {
            throw BadRequestException::create([
                'version' => [
                    'isEmpty',
                ],
            ]);
        }
        if (!$lang) {
            throw BadRequestException::create([
                'lang' => [
                    'isEmpty',
                ],
            ]);
        }

        if (!$publicUrl) {
            throw BadRequestException::create([
                'publicUrl' => [
                    'isEmpty',
                ],
            ]);
        }

        $phpInstance = $em->getRepository(Instance::class)->findOneBy([
            'lang' => $lang,
            'version' => $version,
            'publicUrl' => $publicUrl,
        ]);

        if (!$phpInstance instanceof Instance) {
            $phpInstance = new Instance();
        } else {
            throw PhpInstanceAlreadyRegistered::create();
        }

        $phpInstance->import([
            'lang' => $lang,
            'version' => $version,
            'publicUrl' => $publicUrl,
            'status' => Instance::STATUS_ACTIVE,
        ]);

        $em->persist($phpInstance);
        $em->flush($phpInstance);
    }

}
