<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder\Types;

class LimitType
{
    private int $limit;

    public function __construct(int $limit)
    {
        $this->limit = $limit;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function isEmpty(): bool
    {
        return false;
    }
}
