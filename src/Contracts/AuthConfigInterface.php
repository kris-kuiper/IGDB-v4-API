<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Contracts;

interface AuthConfigInterface
{
    public function setAuthenticationUrl(string $authenticationUrl): self;

    public function getAuthenticationUrl(): string;

    public function setClientId(string $clientId): self;

    public function getClientId(): string;

    public function setClientSecret(string $clientSecret): self;

    public function getClientSecret(): string;
}
