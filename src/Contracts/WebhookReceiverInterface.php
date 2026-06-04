<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\Contracts;

use KrisKuiper\IGDBV4\Exceptions\WebhookException;
use KrisKuiper\IGDBV4\Webhooks\ValueObjects\WebhookPayload;
use Psr\Http\Message\ServerRequestInterface;

interface WebhookReceiverInterface
{
    /**
     * Verifies and parses an incoming IGDB webhook notification.
     *
     * @throws WebhookException
     */
    public function receive(ServerRequestInterface $request): WebhookPayload;

    /**
     * Verifies and parses an IGDB test delivery (triggered through the
     * {endpoint}/webhooks/test/{id} API). Test deliveries arrive with a generic
     * Java user agent and without the X-Endpoint and X-Operation headers, so
     * only the secret is verified and the raw entity is returned.
     *
     * @throws WebhookException
     */
    public function receiveTest(ServerRequestInterface $request): object;
}
