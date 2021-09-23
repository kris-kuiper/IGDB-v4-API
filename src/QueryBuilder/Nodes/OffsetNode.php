<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder\Nodes;

use KrisKuiper\IGDBV4\QueryBuilder\Types\OffsetType;

class OffsetNode extends AbstractNode
{
    public function build(): string
    {
        /** @var OffsetType $offset */
        $offset = $this->items[array_key_last($this->items)];
        return (string) $offset->getOffset();
    }
}
