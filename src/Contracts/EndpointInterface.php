<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Contracts;

use Iterator;

interface EndpointInterface
{
    public function getEndpoint(): string;

    public function findById(int $id, array $fields = null): ?object;

    public function list(int $offset = 0, int $limit = 500, array $fields = null): Iterator;

    public function query(string $query): Iterator;
}
