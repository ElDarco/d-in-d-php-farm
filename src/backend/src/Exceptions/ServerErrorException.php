<?php

declare(strict_types=1);

namespace Exceptions;

use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class ServerErrorException extends \LogicException implements ProblemDetailsExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    public static function create(string $type, string $title, array $additional) : self
    {
        $type = $type ?? 'serverErrorException';
        $e = new self($type);
        $e->status = 500;
        $e->type   = $type;
        $e->title  = $title ?? 'Something Went Wrong';
        $e->detail = self::class;
        $e->additional = $additional;
        return $e;
    }
}