<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder\Nodes;

abstract class AbstractNode
{
    protected array $items = [];

    public function append($type): void
    {
        $this->items[] = $type;
    }

    public function addChild($node): void
    {
        $this->items[] = $node;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function set($type): void
    {
        if (false === $this->has($type::class)) {
            $this->remove($type::class);
        }

        $this->items[] = $type;
    }

    public function has(string $type): bool
    {
        foreach ($this->items as $item) {
            if ($item::class === $type) {
                return true;
            }
        }

        return false;
    }

    public function remove(string $type): void
    {
        foreach ($this->items as $index => $item) {
            if ($item::class === $type) {
                unset($this->items[$index]);
            }
        }
    }

    public function isEmpty(): bool
    {
        return 0 === count($this->items);
    }

    abstract public function build(): string;
}
