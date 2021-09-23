<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder\Types;

class ExcludeType
{
    private array $fields;

    public function __construct(string ...$fields)
    {
        $this->fields = $fields;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function isEmpty(): bool
    {
        return 0 === count($this->fields);
    }
}
