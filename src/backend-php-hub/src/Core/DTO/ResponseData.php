<?php

declare(strict_types=1);

namespace Core\DTO;

/**
 * Class ResponseData
 * @package Core\DTO
 */
class ResponseData
{
    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @param $item
     * @return mixed|string
     */
    public function __get($item)
    {
        return $this->data[$item] ?? '';
    }

    /**
     * @param $item
     * @param $value
     */
    public function __set($item, $value)
    {
        $this->data[$item] = $value;
    }

    /**
     * @param $item
     * @return bool
     */
    public function __isset($item)
    {
        return isset($this->data[$item]);
    }

    /**
     * @return array
     */
    public function __toArray()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function import(array $data) : void
    {
        $this->data = array_merge($this->data, $data);
    }

    /**
     * @param $item
     */
    public function __unset($item)
    {
        unset($this->data[$item]);
    }
}
