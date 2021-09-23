<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder\Traits;

use KrisKuiper\IGDBV4\QueryBuilder\Nodes\NodeCollection;
use KrisKuiper\IGDBV4\QueryBuilder\Types\LogicGate;
use KrisKuiper\IGDBV4\QueryBuilder\WhereNodeQuery;
use KrisKuiper\IGDBV4\QueryBuilder\Types\WhereType;
use Closure;

trait OrWhereTrait
{
    public function orWhere(string|Closure $field, array|string|int|float $value = null, string $operator = '='): self
    {
        if ($field instanceof Closure) {
            $nodeCollection = new NodeCollection();
            $logicGate = new LogicGate('|', $nodeCollection->getWhereNode());
            $this->nodeCollection->getWhereNode()->addChild($logicGate);
            $field(new WhereNodeQuery($nodeCollection));
            return $this;
        }

        $this->nodeCollection->getWhereNode()->append(new WhereType('|', $field, $value, $operator));
        return $this;
    }
}
