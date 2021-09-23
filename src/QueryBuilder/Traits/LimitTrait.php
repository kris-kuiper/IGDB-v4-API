<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder\Traits;

use KrisKuiper\IGDBV4\QueryBuilder\Types\LimitType;

trait LimitTrait
{
    public function limit(int $limit): self
    {
        $nodeCollection = $this->nodeCollection;
        $node = $nodeCollection->getLimitNode();
        $node->set(new LimitType($limit));
        return $this;
    }
}
