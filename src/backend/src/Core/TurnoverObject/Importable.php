<?php

declare(strict_types=1);

namespace Code\TurnoverObject;

/**
 * Interface Importable
 * @package App\Modules\Base\Core
 */
interface Importable extends Magicable
{
    /**
     * @param array $data
     * @return mixed
     */
    public function import(array $data = []);
}
