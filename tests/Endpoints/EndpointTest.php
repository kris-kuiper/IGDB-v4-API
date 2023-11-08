<?php
declare(strict_types=1);

namespace Tests\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use KrisKuiper\IGDBV4\Authentication\ValueObjects\AccessConfig;
use KrisKuiper\IGDBV4\Collections\Collection;
use KrisKuiper\IGDBV4\Contracts\EndpointInterface;
use KrisKuiper\IGDBV4\Endpoints\ {
    AgeRatingContentDescriptionEndpoint,
    AgeRatingEndpoint,
    AlternativeNameEndpoint,
    ArtworkEndpoint,
    CharacterEndpoint,
    CharacterMugShotEndpoint,
    CollectionEndpoint,
    CompanyEndpoint,
    CompanyLogoEndpoint,
    CompanyWebsiteEndpoint,
    CoverEndpoint,
    ExternalGameEndpoint,
    FranchiseEndpoint,
    GameEndpoint,
    GameEngineEndpoint,
    GameEngineLogoEndpoint,
    GameModeEndpoint,
    GameVersionEndpoint,
    GameVersionFeatureEndpoint,
    GameVersionFeatureValueEndpoint,
    GameVideoEndpoint,
    GenreEndpoint,
    InvolvedCompanyEndpoint,
    KeywordEndpoint,
    MultiplayerModeEndpoint,
    PlatformEndpoint,
    PlatformFamilyEndpoint,
    PlatformLogoEndpoint,
    PlatformVersionCompanyEndpoint,
    PlatformVersionEndpoint,
    PlatformVersionReleaseDateEndpoint,
    PlatformWebsiteEndpoint,
    PlayerPerspectiveEndpoint,
    ReleaseDateEndpoint,
    ScreenshotEndpoint,
    SearchEndpoint,
    ThemeEndpoint,
    WebsiteEndpoint
};
use Mockery;
use PHPUnit\Framework\TestCase;

class EndpointTest extends TestCase
{
    private Client $client;

    public function setup(): void {

        $this->client = Mockery::mock(Client::class);
        parent::setup();
    }

    /**
     * @dataProvider endpointProvider
     */
    public function testShouldReturnCorrectEndpointURLWhenAskingEndpointName(string $fqn, $url): void
    {
        $endpoint = $this->getMockForFQNEndpoint($fqn);
        $this->assertEquals($url, $endpoint->getEndpoint());
    }

    /**
     * @dataProvider endpointProvider
     */
    public function testShouldReturnObjectWhenUsingFindById(string $fqn): void
    {
        $endpoint = $this->getMockForFQNEndpoint($fqn);
        $this->client->shouldReceive('request')->andReturn(new Response(200, [], '[{"id": 1}]'));
        $response = $endpoint->findById(1, ['id']);
        $this->assertEquals((object) ['id' => 1], $response);
    }

    /**
     * @dataProvider endpointProvider
     */
    public function testShouldReturnNullWhenTryingToFindUnknownId(string $fqn): void
    {
        $endpoint = $this->getMockForFQNEndpoint($fqn);
        $this->client->shouldReceive('request')->andReturn(new Response(200, [], '[]'));
        $response = $endpoint->findById(10000000, ['id']);
        $this->assertNull($response);
    }

    /**
     * @dataProvider endpointProvider
     */
    public function testShouldReturnCollectionWhenListing(string $fqn): void
    {
        $endpoint = $this->getMockForFQNEndpoint($fqn);
        $this->client->shouldReceive('request')->andReturn(new Response(200, [], '[{"id": 1}, {"id": 2}]'));
        $response = $endpoint->list(0, 2, ['id']);
        $this->assertEquals(new Collection([(object) ['id' => 1], (object) ['id' => 2]]), $response);
    }

    /**
     * @dataProvider endpointProvider
     */
    public function testShouldReturnCollectionWhenUsingCustomQuery(string $fqn): void
    {
        $endpoint = $this->getMockForFQNEndpoint($fqn);
        $this->client->shouldReceive('request')->andReturn(new Response(200, [], '[{"id": 1}]'));
        $response = $endpoint->query('fields id; limit 1;');
        $this->assertEquals(new Collection([(object) ['id' => 1]]), $response);
    }


    /**
     * @dataProvider endpointProvider
     */
    public function testShouldReturnCollectionWithValidObjectsWhenUsingCustomQuery(string $fqn): void
    {
        $endpoint = $this->getMockForFQNEndpoint($fqn);
        $this->client->shouldReceive('request')->andReturn(new Response(200, [], '[{"id":1,"platforms":[{"id":5}]}]'));
        $response = $endpoint->query('fields id platforms.id; limit 1;');
        $this->assertEquals(new Collection([(object) ['id' => 1, 'platforms' => [(object) ['id' => 5]]]]), $response);
    }

    /**
     * Returns a generated mocked endpoint
     */
    private function getMockForFQNEndpoint(string $fqn): EndpointInterface
    {
        $config = new AccessConfig('clientId', 'accessToken');
        return new $fqn($this->client, $config);
    }

    public static function endpointProvider(): array
    {
        return [
            [AgeRatingContentDescriptionEndpoint::class, 'age_rating_content_descriptions'],
            [AgeRatingEndpoint::class, 'age_ratings'],
            [AlternativeNameEndpoint::class, 'alternative_names'],
            [ArtworkEndpoint::class, 'artworks'],
            [CharacterEndpoint::class, 'characters'],
            [CharacterMugShotEndpoint::class, 'character_mug_shots'],
            [CollectionEndpoint::class, 'collections'],
            [CompanyEndpoint::class, 'companies'],
            [CompanyLogoEndpoint::class, 'company_logos'],
            [CompanyWebsiteEndpoint::class, 'company_websites'],
            [CoverEndpoint::class, 'covers'],
            [ExternalGameEndpoint::class, 'external_games'],
            [FranchiseEndpoint::class, 'franchises'],
            [GameEndpoint::class, 'games'],
            [GameEngineEndpoint::class, 'game_engines'],
            [GameEngineLogoEndpoint::class, 'game_engine_logos'],
            [GameModeEndpoint::class, 'game_modes'],
            [GameVersionEndpoint::class, 'game_versions'],
            [GameVersionFeatureEndpoint::class, 'game_version_features'],
            [GameVersionFeatureValueEndpoint::class, 'game_version_feature_values'],
            [GameVideoEndpoint::class, 'game_videos'],
            [GenreEndpoint::class, 'genres'],
            [InvolvedCompanyEndpoint::class, 'involved_companies'],
            [KeywordEndpoint::class, 'keywords'],
            [MultiplayerModeEndpoint::class, 'multiplayer_modes'],
            [PlatformEndpoint::class, 'platforms'],
            [PlatformFamilyEndpoint::class, 'platform_families'],
            [PlatformLogoEndpoint::class, 'platform_logos'],
            [PlatformVersionCompanyEndpoint::class, 'platform_version_companies'],
            [PlatformVersionEndpoint::class, 'platform_versions'],
            [PlatformVersionReleaseDateEndpoint::class, 'platform_version_release_dates'],
            [PlatformWebsiteEndpoint::class, 'platform_websites'],
            [PlayerPerspectiveEndpoint::class, 'player_perspectives'],
            [ReleaseDateEndpoint::class, 'release_dates'],
            [ScreenshotEndpoint::class, 'screenshots'],
            [SearchEndpoint::class, 'search'],
            [ThemeEndpoint::class, 'themes'],
            [WebsiteEndpoint::class, 'websites'],
        ];
    }
}