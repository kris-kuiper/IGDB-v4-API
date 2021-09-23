<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder\Types;

class OffsetType
{
    private int $offset;

    public function __construct(int $offset)
    {
        $this->offset = $offset;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function isEmpty(): bool
    {
        return false;
    }
}
