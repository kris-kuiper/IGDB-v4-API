<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder;

use KrisKuiper\IGDBV4\QueryBuilder\Nodes\NodeCollection;
use KrisKuiper\IGDBV4\QueryBuilder\Traits\OrWhereTrait;
use KrisKuiper\IGDBV4\QueryBuilder\Traits\WhereTrait;

class WhereNodeQuery
{
    use WhereTrait;
    use OrWhereTrait;

    protected NodeCollection $nodeCollection;

    public function __construct(NodeCollection $nodeCollection)
    {
        $this->nodeCollection = $nodeCollection;
    }
}
