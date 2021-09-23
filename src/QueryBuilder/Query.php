<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder;

use KrisKuiper\IGDBV4\QueryBuilder\Nodes\NodeCollection;
use KrisKuiper\IGDBV4\QueryBuilder\Traits\BuildTrait;
use KrisKuiper\IGDBV4\QueryBuilder\Traits\ExcludeTrait;
use KrisKuiper\IGDBV4\QueryBuilder\Traits\FieldsTrait;
use KrisKuiper\IGDBV4\QueryBuilder\Traits\LimitTrait;
use KrisKuiper\IGDBV4\QueryBuilder\Traits\OffsetTrait;
use KrisKuiper\IGDBV4\QueryBuilder\Traits\SearchTrait;
use KrisKuiper\IGDBV4\QueryBuilder\Traits\SortTrait;
use KrisKuiper\IGDBV4\QueryBuilder\Traits\WhereTrait;

class Query
{
    use FieldsTrait;
    use BuildTrait;
    use ExcludeTrait;
    use LimitTrait;
    use OffsetTrait;
    use SearchTrait;
    use SortTrait;
    use WhereTrait;

    protected NodeCollection $nodeCollection;

    public function __construct()
    {
        $this->nodeCollection = new NodeCollection();
    }
}
