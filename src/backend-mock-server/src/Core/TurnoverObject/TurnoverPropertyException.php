<?php

declare(strict_types=1);

namespace Core\TurnoverObject;

use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class TurnoverPropertyException extends \LogicException implements ProblemDetailsExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    public static function create(string $title, string $type = '', array $additional = []) : self
    {
        $type = $type ?? 'turnoverPropertyException';
        $e = new self($type);
        $e->status = 500;
        $e->type   = $type;
        $e->title  = $title ?? 'turnoverPropertyException';
        $e->detail = self::class;
        $e->additional = $additional;
        return $e;
    }
}