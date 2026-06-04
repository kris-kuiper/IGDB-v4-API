<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Webhooks;

use JsonException;
use KrisKuiper\IGDBV4\Contracts\WebhookReceiverInterface;
use KrisKuiper\IGDBV4\Enums\WebhookMethod;
use KrisKuiper\IGDBV4\Exceptions\WebhookException;
use KrisKuiper\IGDBV4\Webhooks\ValueObjects\WebhookPayload;
use Psr\Http\Message\ServerRequestInterface;

class WebhookReceiver implements WebhookReceiverInterface
{
    private const USER_AGENT = 'IGDB-Webhook-Bot';
    private const HEADER_SECRET = 'X-Secret';
    private const HEADER_ENDPOINT = 'X-Endpoint';
    private const HEADER_OPERATION = 'X-Operation';

    public function __construct(private readonly string $secret)
    {
    }

    /**
     * @throws WebhookException
     */
    public function receive(ServerRequestInterface $request): WebhookPayload
    {
        $this->guardUserAgent($request);
        $this->guardSecret($request);

        $endpoint = $request->getHeaderLine(self::HEADER_ENDPOINT);

        if ('' === $endpoint) {
            throw WebhookException::missingHeader(self::HEADER_ENDPOINT);
        }

        $operation = $request->getHeaderLine(self::HEADER_OPERATION);

        if ('' === $operation) {
            throw WebhookException::missingHeader(self::HEADER_OPERATION);
        }

        return WebhookPayload::create($endpoint, WebhookMethod::fromOperation($operation), $this->decode($request));
    }

    /**
     * Skips the user agent and endpoint/operation header guards because IGDB
     * test deliveries do not send them; the secret is still verified.
     *
     * @throws WebhookException
     */
    public function receiveTest(ServerRequestInterface $request): object
    {
        $this->guardSecret($request);

        return $this->decode($request);
    }

    /**
     * @throws WebhookException
     */
    private function guardUserAgent(ServerRequestInterface $request): void
    {
        $userAgent = $request->getHeaderLine('User-Agent');

        if (self::USER_AGENT !== $userAgent) {
            throw WebhookException::invalidUserAgent($userAgent);
        }
    }

    /**
     * @throws WebhookException
     */
    private function guardSecret(ServerRequestInterface $request): void
    {
        if (false === hash_equals($this->secret, $request->getHeaderLine(self::HEADER_SECRET))) {
            throw WebhookException::invalidSecret();
        }
    }

    /**
     * @throws WebhookException
     */
    private function decode(ServerRequestInterface $request): object
    {
        $body = (string) $request->getBody();

        try {
            $decoded = json_decode($body, false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            throw WebhookException::unexpectedResponse($body);
        }

        if (false === is_object($decoded)) {
            throw WebhookException::unexpectedResponse($body);
        }

        return $decoded;
    }
}
