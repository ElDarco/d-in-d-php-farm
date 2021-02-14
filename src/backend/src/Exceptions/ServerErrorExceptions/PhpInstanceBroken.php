<?php

declare(strict_types=1);

namespace Exceptions\ServerErrorExceptions;

use Exceptions\ServerErrorException;
use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;

class PhpInstanceBroken extends ServerErrorException
{
    use CommonProblemDetailsExceptionTrait;

    public static function create(
        string $type = 'PhpInstanceBroken',
        string $title = 'PhpInstance Broken',
        array $additional = []
    ): ServerErrorException {
        return parent::create($type, $title, $additional);
    }
}