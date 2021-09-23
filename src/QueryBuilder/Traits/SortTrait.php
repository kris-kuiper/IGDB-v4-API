<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder\Traits;

use KrisKuiper\IGDBV4\QueryBuilder\Types\SortType;

trait SortTrait
{
    private ?int $offset = null;

    public function sort(string $field, string $direction = 'asc'): self
    {
        $nodeCollection = $this->nodeCollection;
        $node = $nodeCollection->getSortNode();
        $node->set(new SortType($field, $direction));

        return $this;
    }
}
