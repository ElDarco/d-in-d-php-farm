<?php

declare(strict_types=1);

namespace Core\TurnoverObject;

/**
 * Interface Magicable
 * @package App\Modules\Base\Core
 */
interface Magicable
{
    /**
     * @param string $name
     * @return mixed
     */
    public function get($name);

    /**
     * @param string $name
     * @param string $value
     * @return mixed
     */
    public function set($name, $value);

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name);

    /**
     * @param string $name
     * @param string $value
     * @return mixed
     */
    public function __set($name, $value);
}
