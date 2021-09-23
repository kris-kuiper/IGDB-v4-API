<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Contracts;

interface AccessConfigInterface
{
    public function setClientId(string $clientId): self;

    public function getClientId(): string;

    public function setAccessToken(string $accessToken): self;

    public function getAccessToken(): string;
}
