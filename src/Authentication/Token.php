<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Authentication;

use Assert\Assertion;
use Assert\AssertionFailedException;

class Token
{
    private string $accessToken;
    private int $expiration;
    private string $type;

    public function __construct(string $accessToken, int $expiration, string $type)
    {
        $this->accessToken = $accessToken;
        $this->expiration = $expiration;
        $this->type = $type;
    }

    /**
     * @throws AssertionFailedException
     */
    public static function fromArray(array $data): self
    {
        Assertion::keyExists($data, 'access_token');
        Assertion::keyExists($data, 'expires_in');
        Assertion::keyExists($data, 'token_type');
        return new self($data['access_token'], $data['expires_in'], $data['token_type']);
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getExpiration(): int
    {
        return $this->expiration;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
