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
}
