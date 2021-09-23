<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder\Nodes;

use KrisKuiper\IGDBV4\QueryBuilder\Types\SortType;

class SortNode extends AbstractNode
{
    public function build(): string
    {
        /** @var SortType $sort */
        $sort = $this->items[array_key_last($this->items)];
        return $sort->getField() . ' ' . $sort->getDirection();
    }
}
