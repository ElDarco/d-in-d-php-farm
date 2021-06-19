<?php

declare(strict_types=1);

namespace Exceptions\NotFoundExceptions;

use Exceptions\NotFoundException;
use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;

class NamespaceNotFound extends NotFoundException
{
    use CommonProblemDetailsExceptionTrait;

    public static function create(
        string $type = 'NamespaceNotFound',
        string $title = 'Namespace Not Found',
        array $additional = []
    ): NotFoundException {
        return parent::create($type, $title, $additional);
    }
}