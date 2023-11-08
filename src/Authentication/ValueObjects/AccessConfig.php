<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Authentication\ValueObjects;

use KrisKuiper\IGDBV4\Contracts\AccessConfigInterface;

class AccessConfig implements AccessConfigInterface
{
    private string $clientId;
    private string $accessToken;

    public function __construct(string $clientId, string $accessToken)
    {
        $this->clientId = $clientId;
        $this->accessToken = $accessToken;
    }

    public function setClientId(string $clientId): self
    {
        $instance = clone $this;
        $instance->clientId = $clientId;
        return $instance;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function setAccessToken(string $accessToken): self
    {
        $instance = clone $this;
        $instance->accessToken = $accessToken;
        return $instance;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }
}
