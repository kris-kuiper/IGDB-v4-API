<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder\Nodes;

class ExcludeNode extends AbstractNode
{
    public function build(): string
    {
        $fields = [];

        foreach ($this->items as $item) {
            $fields[] = $item->getFields();
        }

        return implode(', ', array_unique(array_merge([], ...$fields)));
    }
}
