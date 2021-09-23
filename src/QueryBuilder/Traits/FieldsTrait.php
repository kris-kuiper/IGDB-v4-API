<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder\Traits;

use KrisKuiper\IGDBV4\QueryBuilder\Types\FieldsType;

trait FieldsTrait
{
    public function fields(string ...$fields): self
    {
        $nodeCollection = $this->nodeCollection;
        $node = $nodeCollection->getFieldsNode();
        $node->set(new FieldsType(...$fields));
        return $this;
    }
}
