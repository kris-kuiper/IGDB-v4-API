<?php
declare(strict_types=1);

namespace Tests\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use KrisKuiper\IGDBV4\Authentication\ValueObjects\AccessConfig;
use KrisKuiper\IGDBV4\Endpoints\GameEndpoint;
use KrisKuiper\IGDBV4\Exceptions\RequestException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * Drives the endpoints through a real Guzzle client with a mocked transport, so the request
 * that leaves the package is asserted as Guzzle builds it on every supported major version.
 */
class RequestTest extends TestCase
{
    private array $transactions = [];

    public function testShouldSendAuthenticatedApicalypseRequestWhenQuerying(): void
    {
        $endpoint = $this->getEndpointRespondingWith(new Response(200, [], '[{"id": 1}]'));
        $endpoint->query('fields id; limit 1;');

        $request = $this->getLastRequest();
        $this->assertSame('POST', $request->getMethod());
        $this->assertSame('https://api.igdb.com/v4/games', (string) $request->getUri());
        $this->assertSame('fields id; limit 1;', (string) $request->getBody());
        $this->assertSame('text/plain', $request->getHeaderLine('Content-Type'));
        $this->assertSame('clientId', $request->getHeaderLine('Client-ID'));
        $this->assertSame('bearer accessToken', $request->getHeaderLine('Authorization'));
    }

    public function testShouldSendQueryToCountingEndpointWhenCounting(): void
    {
        $endpoint = $this->getEndpointRespondingWith(new Response(200, [], '{"count": 12345}'));
        $count = $endpoint->count('where rating > 75;');

        $request = $this->getLastRequest();
        $this->assertSame('POST', $request->getMethod());
        $this->assertSame('https://api.igdb.com/v4/games/count', (string) $request->getUri());
        $this->assertSame('where rating > 75;', (string) $request->getBody());
        $this->assertSame('bearer accessToken', $request->getHeaderLine('Authorization'));
        $this->assertSame(12345, $count);
    }

    public function testShouldThrowExceptionWhenCountingRespondsWithoutACount(): void
    {
        $endpoint = $this->getEndpointRespondingWith(new Response(200, [], '{"message": "no can do"}'));

        $this->expectException(RequestException::class);
        $endpoint->count();
    }

    public function testShouldThrowExceptionWhenCountingRespondsWithMalformedJson(): void
    {
        $endpoint = $this->getEndpointRespondingWith(new Response(200, [], 'not json'));

        $this->expectException(RequestException::class);
        $endpoint->count();
    }

    /**
     * Returns an endpoint backed by a real Guzzle client whose transport is mocked.
     */
    private function getEndpointRespondingWith(Response $response): GameEndpoint
    {
        $stack = HandlerStack::create(new MockHandler([$response]));
        $stack->push(Middleware::history($this->transactions));

        return new GameEndpoint(new Client(['handler' => $stack]), new AccessConfig('clientId', 'accessToken'));
    }

    private function getLastRequest(): RequestInterface
    {
        $transaction = end($this->transactions);
        $this->assertIsArray($transaction);

        return $transaction['request'];
    }
}
