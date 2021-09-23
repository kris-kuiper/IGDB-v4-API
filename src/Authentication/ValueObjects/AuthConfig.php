<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Authentication\ValueObjects;

use KrisKuiper\IGDBV4\Contracts\AuthConfigInterface;

class AuthConfig implements AuthConfigInterface
{
    private const AUTHENTICATION_URL = 'https://id.twitch.tv/oauth2/token';

    private string $clientId;
    private string $clientSecret;
    private string $authenticationUrl;

    public function __construct(string $clientId, string $clientSecret, string $authenticationUrl = self::AUTHENTICATION_URL)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->authenticationUrl = $authenticationUrl;
    }

    public function setAuthenticationUrl(string $authenticationUrl): self
    {
        $instance = clone $this;
        $instance->authenticationUrl = $authenticationUrl;
        return $instance;
    }

    public function getAuthenticationUrl(): string
    {
        return $this->authenticationUrl;
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

    public function setClientSecret(string $clientSecret): self
    {
        $instance = clone $this;
        $instance->clientSecret = $clientSecret;
        return $instance;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }
}
