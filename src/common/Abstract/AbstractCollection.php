<?php

namespace App\common\Abstract;

use App\common\Abstract\Exception\CollectionTypeException;
use Traversable;

abstract class AbstractCollection implements \IteratorAggregate, \Countable, \ArrayAccess
{
    protected array $collection = [];

    abstract protected function getClassName(): string;

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->collection);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->collection[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->offsetExists($offset) ? $this->collection[$offset] : null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($this->getClassName() !== $value::class) {
            throw new CollectionTypeException();
        }

        if (is_null($offset)) {
            $this->collection[] = $value;
        } else {
            $this->collection[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->collection[$offset]);
    }

    public function count(): int
    {
        return count($this->collection);
    }
}