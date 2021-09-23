<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder\Traits;

use KrisKuiper\IGDBV4\QueryBuilder\Types\OffsetType;

trait OffsetTrait
{
    private ?int $offset = null;
    public function offset(int $offset): self
    {
        $nodeCollection = $this->nodeCollection;
        $node = $nodeCollection->getOffsetNode();
        $node->set(new OffsetType($offset));
        return $this;
    }
}
