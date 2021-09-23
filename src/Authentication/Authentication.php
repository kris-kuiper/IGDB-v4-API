<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Authentication;

use Assert\AssertionFailedException;
use GuzzleHttp\Client;
use JsonException;
use KrisKuiper\IGDBV4\Exceptions\AuthenticationException;
use KrisKuiper\IGDBV4\Contracts\AuthConfigInterface;
use Psr\Http\Client\ClientExceptionInterface;

class Authentication
{
    private AuthConfigInterface $config;
    private Client $client;

    public function __construct(Client $client, AuthConfigInterface $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * @throws AuthenticationException|JsonException
     */
    public function obtainToken(): Token
    {
        try {
            $response = $this->client->request('POST', $this->config->getAuthenticationUrl(), [
                'form_params' => [
                    'client_id' => $this->config->getClientId(),
                    'client_secret' => $this->config->getClientSecret(),
                    'grant_type' => 'client_credentials',
                ],
            ]);
        } catch (ClientExceptionInterface $exception) {
            throw match ($exception->getCode()) {
                403 => AuthenticationException::invalidClientSecret(),
                400 => AuthenticationException::invalidClient(),
                default => AuthenticationException::authenticationFailed($exception),
            };
        }

        $tokenData = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        try {
            $token = Token::fromArray($tokenData);
        } catch (AssertionFailedException $exception) {
            throw AuthenticationException::authenticationFailed($exception);
        }

        return $token;
    }
}
