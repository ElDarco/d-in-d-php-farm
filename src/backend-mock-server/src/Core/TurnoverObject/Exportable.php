<?php

declare(strict_types=1);

namespace Core\TurnoverObject;

/**
 * Interface Exportable
 * @package App\Modules\Base\Core
 */
interface Exportable extends Magicable
{
    /**
     * @param array $ignore
     * @param array $needed
     * @return mixed
     */
    public function export(array $ignore = [], array $needed = []);
}
