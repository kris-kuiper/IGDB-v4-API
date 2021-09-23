<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder;

use KrisKuiper\IGDBV4\QueryBuilder\Nodes\NodeCollection;
use KrisKuiper\IGDBV4\QueryBuilder\Traits\BuildTrait;
use KrisKuiper\IGDBV4\QueryBuilder\Traits\ExcludeTrait;
use KrisKuiper\IGDBV4\QueryBuilder\Traits\FieldsTrait;
use KrisKuiper\IGDBV4\QueryBuilder\Traits\LimitTrait;
use KrisKuiper\IGDBV4\QueryBuilder\Traits\OffsetTrait;
use KrisKuiper\IGDBV4\QueryBuilder\Traits\OrWhereTrait;
use KrisKuiper\IGDBV4\QueryBuilder\Traits\SearchTrait;
use KrisKuiper\IGDBV4\QueryBuilder\Traits\SortTrait;
use KrisKuiper\IGDBV4\QueryBuilder\Traits\WhereTrait;

class WhereQuery
{
    use FieldsTrait;
    use BuildTrait;
    use ExcludeTrait;
    use FieldsTrait;
    use LimitTrait;
    use OffsetTrait;
    use OrWhereTrait;
    use SearchTrait;
    use SortTrait;
    use WhereTrait;

    protected NodeCollection $nodeCollection;

    public function __construct(NodeCollection $nodeCollection)
    {
        $this->nodeCollection = $nodeCollection;
    }
}
