<?php

declare(strict_types=1);

namespace Core\TurnoverObject;

use Core\TurnoverObject\TurnoverPropertyException;
use Doctrine\Common\Collections\Collection;

class TurnoverObject implements Exportable, Importable
{
    /**
     * @param array $data
     * @throws TurnoverPropertyException
     */
    public function import(array $data = [])
    {
        if (!is_array($data) || empty($data)) {
            return;
        }

        foreach ($data as $key => $val) {
            $key = trim((string) $key);

            if (property_exists($this, $key)) {
                $this->set($key, $val);
            }
        }
    }

    /**
     * @param string $name
     *
     * @return mixed
     * @throws \Exception
     */
    public function get($name)
    {
        return $this->__get($name);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     * @throws TurnoverPropertyException
     */
    public function set($name, $value)
    {
        if (property_exists($this, 'disable_set') && in_array($name, $this->disable_set)) {
            throw TurnoverPropertyException::create('cannot set property: ' . $name);
        }

        return $this->__set($name, $value);
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        if (method_exists($this, 'get' . ucfirst($name))) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }

        if (property_exists($this, $name)) {
            return $this->$name;
        }

        throw TurnoverPropertyException::create('invalid property name: ' . $name);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     * @throws \Exception
     */
    public function __set($name, $value)
    {
        if (property_exists($this, 'disable_set') && in_array($name, $this->disable_set)) {
            throw TurnoverPropertyException::create('cannot set property: ' . $name);
        }

        if (!property_exists($this, $name)) {
            throw TurnoverPropertyException::create('invalid property name: ' . $name);
        }

        if (method_exists($this, 'set' . ucfirst($name))) {
            $method = 'set' . ucfirst($name);
            return $this->$method($value);
        }

        return $this->$name = $value;
    }

    /**
     * Экспорт сущности в массив.
     * @param array $ignore
     * @param array $needed
     * @return array
     * @throws \ReflectionException
     */
    public function export(array $ignore = [], array $needed = [])
    {
        $result = [];

        $reflect = new \ReflectionClass($this);
        $props   = $reflect->getProperties(\ReflectionProperty::IS_PRIVATE + \ReflectionProperty::IS_PROTECTED);

        // @codeCoverageIgnoreStart
        if (!count($props)) {
            return [];
        }
        // @codeCoverageIgnoreEnd

        foreach ($props as $prop) {
            if (in_array($prop->getName(), $ignore)) {
                continue;
            }

            if (!empty($needed) && !in_array($prop->getName(), $needed)) {
                continue;
            }

            $value = $this->get($prop->getName());

            // если атрибут сущности является сущностью, то экспортируем его
            if ($value instanceof Exportable) {
                // в случае двунаправленного отношения
                // убеждаемся в том, чтобы не уйти в рекурсию
                if (in_array(get_class($value), $ignore)) {
                    continue;
                }

                $result[$prop->getName()] = $value->export(array_merge($ignore, [$reflect->name]));
            } elseif ($value instanceof \DateTimeInterface) {
                $result['orig' . ucwords($prop->getName())] = $value->format('Y-m-d H:i:s');
                $result[$prop->getName()] = $value->format('Y-m-d');
            } elseif ($value instanceof Collection) {
                // если атрибут является коллекцией, то каждый элемент этой коллекции тоже нуждается в экспорте
                $result[$prop->getName()] = array_map(function ($entity) use ($ignore, $reflect) {
                    return $entity->export(array_merge($ignore, [$reflect->name]));
                }, array_values($value->toArray()));
            } elseif ($value instanceof \Core\DTO\Multiple\BaseMultipleSingleDTO) {
                $result[$prop->getName()] = [];
                foreach ($value as $element) {
                    if ($element instanceof Exportable) {
                        $result[$prop->getName()][] = $element->export(array_merge($ignore, [$reflect->name]));
                    }
                }
            } else {
                $result[$prop->getName()] = $value;
            }
        }

        if (array_key_exists('disable_set', $result)) {
            unset($result['disable_set']);
        }

        return $result;
    }
}
