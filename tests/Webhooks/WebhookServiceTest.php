<?php

declare(strict_types=1);

namespace Tests\Webhooks;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use KrisKuiper\IGDBV4\Authentication\ValueObjects\AccessConfig;
use KrisKuiper\IGDBV4\Collections\WebhookCollection;
use KrisKuiper\IGDBV4\Enums\WebhookMethod;
use KrisKuiper\IGDBV4\Webhooks\ValueObjects\Webhook;
use KrisKuiper\IGDBV4\Webhooks\WebhookService;
use Mockery;
use PHPUnit\Framework\TestCase;

class WebhookServiceTest extends TestCase
{
    private const WEBHOOK_JSON = '{"id":123,"url":"https://example.com/hook","category":1,"sub_category":0,"active":true,"api_key":"clientId","secret":"s3cr3t","created_at":"2018-11-25T23:00:00.000Z","updated_at":"2018-11-25T23:00:00.000Z"}';

    private Client $client;

    public function setUp(): void
    {
        $this->client = Mockery::mock(Client::class);
        parent::setUp();
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    // Posts form-encoded credentials to {endpoint}/webhooks/ and maps the response to a Webhook.
    public function testShouldRegisterWebhookAndReturnWebhookObject(): void
    {
        $this->client
            ->shouldReceive('request')
            ->once()
            ->with('POST', 'https://api.igdb.com/v4/games/webhooks/', Mockery::on(static function (array $options): bool {
                return ['url' => 'https://example.com/hook', 'method' => 'create', 'secret' => 's3cr3t'] === $options['form_params'];
            }))
            ->andReturn(new Response(200, [], self::WEBHOOK_JSON));

        $webhook = $this->service()->register('games', 'https://example.com/hook', WebhookMethod::CREATE, 's3cr3t');

        $this->assertInstanceOf(Webhook::class, $webhook);
        $this->assertSame(123, $webhook->getId());
        $this->assertSame('https://example.com/hook', $webhook->getUrl());
        $this->assertTrue($webhook->isActive());
    }

    // Regression: IGDB wraps the created webhook in a one-element list, like the list response.
    public function testShouldRegisterWebhookWhenResponseIsWrappedInList(): void
    {
        $this->client
            ->shouldReceive('request')
            ->once()
            ->andReturn(new Response(200, [], '[' . self::WEBHOOK_JSON . ']'));

        $webhook = $this->service()->register('games', 'https://example.com/hook', WebhookMethod::UPDATE, 's3cr3t');

        $this->assertInstanceOf(Webhook::class, $webhook);
        $this->assertSame(123, $webhook->getId());
    }

    // GET webhooks/ returns a JSON array that maps to a typed WebhookCollection.
    public function testShouldReturnCollectionOfWebhooksWhenListingAll(): void
    {
        $this->client
            ->shouldReceive('request')
            ->once()
            ->with('GET', 'https://api.igdb.com/v4/webhooks/', Mockery::any())
            ->andReturn(new Response(200, [], '[' . self::WEBHOOK_JSON . ',' . self::WEBHOOK_JSON . ']'));

        $collection = $this->service()->all();

        $this->assertInstanceOf(WebhookCollection::class, $collection);
        $this->assertSame(2, $collection->count());
        $this->assertInstanceOf(Webhook::class, $collection->first());
    }

    // GET webhooks/{id} returns the matching webhook object.
    public function testShouldReturnWebhookWhenFindingById(): void
    {
        $this->client
            ->shouldReceive('request')
            ->once()
            ->with('GET', 'https://api.igdb.com/v4/webhooks/123', Mockery::any())
            ->andReturn(new Response(200, [], self::WEBHOOK_JSON));

        $webhook = $this->service()->find(123);

        $this->assertInstanceOf(Webhook::class, $webhook);
        $this->assertSame(123, $webhook->getId());
    }

    // An empty array response means the webhook does not exist, so null is returned.
    public function testShouldReturnNullWhenFindingUnknownWebhook(): void
    {
        $this->client
            ->shouldReceive('request')
            ->once()
            ->andReturn(new Response(200, [], '[]'));

        $this->assertNull($this->service()->find(999));
    }

    // DELETE webhooks/{id} echoes back only the id, which is returned as an int.
    public function testShouldReturnDeletedIdentifierWhenDeletingWebhook(): void
    {
        $this->client
            ->shouldReceive('request')
            ->once()
            ->with('DELETE', 'https://api.igdb.com/v4/webhooks/123', Mockery::any())
            ->andReturn(new Response(200, [], '{"id":"123"}'));

        $this->assertSame(123, $this->service()->delete(123));
    }

    // The test helper posts to {endpoint}/webhooks/test/{id} with the entityId query parameter.
    public function testShouldTriggerTestNotificationWithEntityIdQuery(): void
    {
        $this->client
            ->shouldReceive('request')
            ->once()
            ->with('POST', 'https://api.igdb.com/v4/games/webhooks/test/123', Mockery::on(static function (array $options): bool {
                return ['entityId' => 1337] === $options['query'];
            }))
            ->andReturn(new Response(200, [], ''));

        $this->service()->test('games', 123, 1337);

        $this->expectNotToPerformAssertions();
    }

    private function service(): WebhookService
    {
        return new WebhookService($this->client, new AccessConfig('clientId', 'accessToken'));
    }
}
