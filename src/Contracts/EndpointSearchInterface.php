<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Contracts;

interface EndpointSearchInterface extends EndpointInterface
{
    public function search(string $name, array $fields = null): array;
}
