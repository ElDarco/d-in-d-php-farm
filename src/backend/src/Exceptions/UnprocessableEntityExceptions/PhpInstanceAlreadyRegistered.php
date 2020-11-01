<?php

declare(strict_types=1);

namespace Exceptions;

use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class PhpInstanceAlreadyRegistered extends UnprocessableEntityException
{
    use CommonProblemDetailsExceptionTrait;

    public static function create(
        string $type = 'PhpInstanceAlreadyRegistered',
        string $title = 'PhpInstance Already Registered',
        array $additional = []
    ): UnprocessableEntityException {
        return parent::create($type, $title, $additional);
    }
}