<?php

namespace Pjotr\Muis\Resources\Arrays;

use Exception;

abstract class AbstractArray implements \ArrayAccess, \Countable
{
    private array $container = [];

    abstract protected function getItemClass(): string;

    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->container[$offset] : null;
    }

    /**
     * @throws Exception
     */
    public function offsetSet($offset, $value)
    {
        if (! is_a($value, $this->getItemClass())) {
            throw new Exception('Value must be an instance of '.$this->getItemClass());
        }
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    public function count(): int
    {
        return count($this->container);
    }

    public function __toString(): string
    {
        return implode('; ', array_map(function ($single) {
            return (string) $single;
        }, $this->container));
    }
}