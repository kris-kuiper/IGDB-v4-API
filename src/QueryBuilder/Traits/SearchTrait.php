<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder\Traits;

use KrisKuiper\IGDBV4\QueryBuilder\Types\SearchType;

trait SearchTrait
{
    public function search(string $name): self
    {
        $nodeCollection = $this->nodeCollection;
        $node = $nodeCollection->getSearchNode();
        $node->set(new SearchType($name));
        return $this;
    }
}
