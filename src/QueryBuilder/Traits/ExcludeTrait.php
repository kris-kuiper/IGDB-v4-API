<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder\Traits;

use KrisKuiper\IGDBV4\QueryBuilder\Types\ExcludeType;

trait ExcludeTrait
{
    public function exclude(string ...$fields): self
    {
        $nodeCollection = $this->nodeCollection;
        $node = $nodeCollection->getExcludeNode();
        $node->set(new ExcludeType(...$fields));
        return $this;
    }
}
