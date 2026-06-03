<?php

declare(strict_types=1);

namespace Tests\Webhooks;

use GuzzleHttp\Psr7\ServerRequest;
use KrisKuiper\IGDBV4\Enums\WebhookMethod;
use KrisKuiper\IGDBV4\Exceptions\WebhookException;
use KrisKuiper\IGDBV4\Webhooks\WebhookReceiver;
use PHPUnit\Framework\TestCase;

class WebhookReceiverTest extends TestCase
{
    private const SECRET = 'my-secret';

    // A correctly signed notification is parsed into a WebhookPayload with endpoint, operation and entity.
    public function testShouldParseValidNotificationIntoPayload(): void
    {
        $request = $this->request(self::SECRET, 'games', 'create', '{"id":1337,"name":"Half-Life"}');

        $payload = $this->receiver()->receive($request);

        $this->assertSame('games', $payload->getEndpoint());
        $this->assertSame(WebhookMethod::CREATE, $payload->getOperation());
        $this->assertSame(1337, $payload->getId());
        $this->assertSame('Half-Life', $payload->getData()->name);
    }

    // A delete notification only carries the id, which is still exposed through the payload.
    public function testShouldExposeIdForDeleteNotification(): void
    {
        $request = $this->request(self::SECRET, 'games', 'delete', '{"id":1337}');

        $payload = $this->receiver()->receive($request);

        $this->assertSame(WebhookMethod::DELETE, $payload->getOperation());
        $this->assertSame(1337, $payload->getId());
    }

    // A mismatching X-Secret header is rejected to prevent spoofed requests.
    public function testShouldRejectNotificationWithInvalidSecret(): void
    {
        $this->expectException(WebhookException::class);

        $request = $this->request('wrong-secret', 'games', 'create', '{"id":1}');
        $this->receiver()->receive($request);
    }

    // Only requests from the IGDB-Webhook-Bot user agent are accepted.
    public function testShouldRejectNotificationWithInvalidUserAgent(): void
    {
        $this->expectException(WebhookException::class);

        $request = (new ServerRequest('POST', 'https://example.com/hook', [
            'User-Agent' => 'Evil-Bot',
            'X-Secret' => self::SECRET,
            'X-Endpoint' => 'games',
            'X-Operation' => 'create',
        ], '{"id":1}'));

        $this->receiver()->receive($request);
    }

    // A missing X-Endpoint header makes the payload unusable and is rejected.
    public function testShouldRejectNotificationWithMissingEndpointHeader(): void
    {
        $this->expectException(WebhookException::class);

        $request = (new ServerRequest('POST', 'https://example.com/hook', [
            'User-Agent' => 'IGDB-Webhook-Bot',
            'X-Secret' => self::SECRET,
            'X-Operation' => 'create',
        ], '{"id":1}'));

        $this->receiver()->receive($request);
    }

    private function receiver(): WebhookReceiver
    {
        return new WebhookReceiver(self::SECRET);
    }

    private function request(string $secret, string $endpoint, string $operation, string $body): ServerRequest
    {
        return new ServerRequest('POST', 'https://example.com/hook', [
            'User-Agent' => 'IGDB-Webhook-Bot',
            'X-Secret' => $secret,
            'X-Endpoint' => $endpoint,
            'X-Operation' => $operation,
        ], $body);
    }
}
