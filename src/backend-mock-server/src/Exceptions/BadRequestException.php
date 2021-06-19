<?php

declare(strict_types=1);

namespace Exceptions;

use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class BadRequestException extends \LogicException implements ProblemDetailsExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    public static function create(array $validationErrors, string $type = '', string $title = '') : self
    {
        $type = $type ?? 'badRequestException';
        $e = new self($type);
        $e->status = 400;
        $e->type   = $type;
        $e->title  = $title ?? 'Invalid Request';
        $e->detail = self::class;
        $e->additional = [
            'validationErrors' => $validationErrors
        ];
        return $e;
    }
}