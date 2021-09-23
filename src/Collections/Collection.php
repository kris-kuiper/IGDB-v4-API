<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Collections;

use Iterator;

class Collection implements Iterator
{
    private array $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function key(): string|int|null
    {
        return key($this->items);
    }

    public function first(): mixed
    {
        return $this->items[array_key_first($this->items)];
    }

    public function valid(): bool
    {
        return null !== $this->key();
    }

    public function rewind(): void
    {
        reset($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function current(): mixed
    {
        return ($item = current($this->items)) ? $item : null;
    }

    public function next(): void
    {
        next($this->items);
    }

    public function append(mixed $item): void
    {
        $this->items[] = $item;
    }

    public function toArray(): array
    {
        return $this->items;
    }
}
