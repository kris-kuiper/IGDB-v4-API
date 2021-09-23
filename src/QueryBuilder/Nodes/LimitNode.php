<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder\Nodes;

use KrisKuiper\IGDBV4\QueryBuilder\Types\LimitType;

class LimitNode extends AbstractNode
{
    public function build(): string
    {
        /** @var LimitType $limit */
        $limit = $this->items[array_key_last($this->items)];
        return (string) $limit->getLimit();
    }
}
