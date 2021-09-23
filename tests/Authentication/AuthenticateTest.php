<?php
declare(strict_types=1);

namespace Tests\Authentication;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use JsonException;
use KrisKuiper\IGDBV4\Authentication\ValueObjects\AuthConfig;
use KrisKuiper\IGDBV4\Exceptions\AuthenticationException;
use Mockery;
use PHPUnit\Framework\TestCase;
use KrisKuiper\IGDBV4\Authentication\Authentication;

class AuthenticateTest extends TestCase
{
    /**
     * @throws JsonException|AuthenticationException
     */
    public function testShouldReturnTokenWhenGivenValidCredentials(): void
    {
        $config = new AuthConfig('id', 'secret');
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('request')->andReturn(new Response(200, [], '{"access_token":"io2u91wv12lh1sj0oeyfnzq0bqse0y","expires_in":4693339,"token_type":"bearer"}'));

        $authentication = new Authentication($client, $config);
        $token = $authentication->obtainToken();

        $this->assertIsInt($token->getExpiration());
        $this->assertEquals('bearer', $token->getType());
        $this->assertIsString($token->getAccessToken());
    }

    /**
     * @throws JsonException
     */
    public function testShouldRaiseExceptionWhenGivenInvalidClientId(): void
    {
        $this->expectException(AuthenticationException::class);

        $config = new AuthConfig('id', 'secret');
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('request')->andThrow(AuthenticationException::class)->andReturn(new Response(400, [], '{"status":400,"message":"invalid client"}'));

        $authentication = new Authentication($client, $config);
        $authentication->obtainToken();
    }

    /**
     * @throws JsonException
     */
    public function testShouldRaiseExceptionWhenGivenInvalidClientSecret(): void
    {
        $this->expectException(AuthenticationException::class);

        $config = new AuthConfig('id', 'secret');
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('request')->andThrow(AuthenticationException::class)->andReturn(new Response(403, [], '{"status":403,"message":"invalid client secret"}'));

        $authentication = new Authentication($client, $config);
        $authentication->obtainToken();
    }
}