<?php

declare(strict_types=1);

namespace Exceptions;

use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class NotFoundException extends \LogicException implements ProblemDetailsExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    public static function create(string $type, string $title, array $additional) : self
    {
        $type = $type ?? 'notFoundException';
        $e = new self($type);
        $e->status = 404;
        $e->type   = $type;
        $e->title  = $title ?? 'Not Found';
        $e->detail = self::class;
        $e->additional = $additional;
        return $e;
    }
}