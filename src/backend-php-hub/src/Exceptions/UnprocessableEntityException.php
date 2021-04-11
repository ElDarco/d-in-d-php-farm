<?php

declare(strict_types=1);

namespace Exceptions;

use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class UnprocessableEntityException extends \LogicException implements ProblemDetailsExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    public static function create(string $type, string $title, array $additional) : self
    {
        $type = $type ?? 'unprocessableEntityExceptions';
        $e = new self($type);
        $e->status = 422;
        $e->type   = $type;
        $e->title  = $title ?? 'Unprocessable Entity Exceptions';
        $e->detail = self::class;
        $e->additional = $additional;
        return $e;
    }
}