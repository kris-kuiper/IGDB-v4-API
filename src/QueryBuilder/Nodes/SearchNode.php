<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder\Nodes;

use KrisKuiper\IGDBV4\QueryBuilder\Types\SearchType;

class SearchNode extends AbstractNode
{
    public function build(): string
    {
        /** @var SearchType $search */
        $search = $this->items[array_key_last($this->items)];
        return str_replace('"', '\"', $search->getName());
    }
}
