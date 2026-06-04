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

    // Real deliveries send "Games"/"UPDATE" casing; the payload normalizes to the registered lowercase slug.
    public function testShouldNormalizeEndpointAndOperationCasing(): void
    {
        $request = $this->request(self::SECRET, 'Games', 'UPDATE', '{"id":1337}');

        $payload = $this->receiver()->receive($request);

        $this->assertSame('games', $payload->getEndpoint());
        $this->assertSame(WebhookMethod::UPDATE, $payload->getOperation());
    }

    // Test deliveries (Java user agent, no X-Endpoint/X-Operation) only verify the secret.
    public function testShouldAcceptTestDeliveryWithValidSecret(): void
    {
        $request = new ServerRequest('POST', 'https://example.com/hook', [
            'User-Agent' => 'Java/17.0.2',
            'X-Secret' => self::SECRET,
        ], '{"id":1337,"name":"Half-Life"}');

        $data = $this->receiver()->receiveTest($request);

        $this->assertSame(1337, $data->id);
        $this->assertSame('Half-Life', $data->name);
    }

    // A test delivery with a wrong secret is still rejected.
    public function testShouldRejectTestDeliveryWithInvalidSecret(): void
    {
        $this->expectException(WebhookException::class);

        $request = new ServerRequest('POST', 'https://example.com/hook', [
            'User-Agent' => 'Java/17.0.2',
            'X-Secret' => 'wrong-secret',
        ], '{"id":1337}');

        $this->receiver()->receiveTest($request);
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
