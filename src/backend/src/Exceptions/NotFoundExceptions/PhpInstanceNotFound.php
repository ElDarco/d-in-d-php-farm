<?php

declare(strict_types=1);

namespace Exceptions;

use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class PhpInstanceNotFound extends NotFoundException
{
    use CommonProblemDetailsExceptionTrait;

    public static function create(
        string $type = 'PhpInstanceNotFound',
        string $title = 'PhpInstance Not Found',
        array $additional = []
    ): NotFoundException {
        return parent::create($type, $title, $additional);
    }
}