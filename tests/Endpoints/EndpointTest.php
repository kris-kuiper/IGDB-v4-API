<?php
declare(strict_types=1);

namespace Tests\Endpoints;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use KrisKuiper\IGDBV4\Authentication\ValueObjects\AccessConfig;
use KrisKuiper\IGDBV4\Collections\Collection;
use KrisKuiper\IGDBV4\Contracts\EndpointInterface;
use KrisKuiper\IGDBV4\Exceptions\RequestException;
use KrisKuiper\IGDBV4\Endpoints\ {
    AgeRatingCategoryEndpoint,
    AgeRatingContentDescriptionEndpoint,
    AgeRatingContentDescriptionTypeEndpoint,
    AgeRatingContentDescriptionV2Endpoint,
    AgeRatingEndpoint,
    AgeRatingOrganizationEndpoint,
    AlternativeNameEndpoint,
    ArtworkEndpoint,
    ArtworkTypeEndpoint,
    CharacterEndpoint,
    CharacterGenderEndpoint,
    CharacterMugShotEndpoint,
    CharacterSpeciesEndpoint,
    CollectionEndpoint,
    CollectionMembershipEndpoint,
    CollectionMembershipTypeEndpoint,
    CollectionRelationEndpoint,
    CollectionRelationTypeEndpoint,
    CollectionTypeEndpoint,
    CompanyEndpoint,
    CompanyLogoEndpoint,
    CompanySizeEndpoint,
    CompanyStatusEndpoint,
    CompanyTypeEndpoint,
    CompanyTypeHistoryEndpoint,
    CompanyWebsiteEndpoint,
    CoverEndpoint,
    DateFormatEndpoint,
    EntityTypeEndpoint,
    EventEndpoint,
    EventLogoEndpoint,
    EventNetworkEndpoint,
    ExternalGameEndpoint,
    ExternalGameSourceEndpoint,
    FranchiseEndpoint,
    GameEndpoint,
    GameEngineEndpoint,
    GameEngineLogoEndpoint,
    GameLocalizationEndpoint,
    GameModeEndpoint,
    GameReleaseFormatEndpoint,
    GameStatusEndpoint,
    GameTimeToBeatEndpoint,
    GameTypeEndpoint,
    GameVersionEndpoint,
    GameVersionFeatureEndpoint,
    GameVersionFeatureValueEndpoint,
    GameVideoEndpoint,
    GenreEndpoint,
    ImageTypeEndpoint,
    InvolvedCompanyEndpoint,
    KeywordEndpoint,
    LanguageEndpoint,
    LanguageSupportEndpoint,
    LanguageSupportTypeEndpoint,
    MultiplayerModeEndpoint,
    NetworkTypeEndpoint,
    PlatformEndpoint,
    PlatformFamilyEndpoint,
    PlatformLogoEndpoint,
    PlatformTypeEndpoint,
    PlatformVersionCompanyEndpoint,
    PlatformVersionEndpoint,
    PlatformVersionReleaseDateEndpoint,
    PlatformWebsiteEndpoint,
    PlayerPerspectiveEndpoint,
    PopularityPrimitiveEndpoint,
    PopularityTypeEndpoint,
    RegionEndpoint,
    ReleaseDateEndpoint,
    ReleaseDateRegionEndpoint,
    ReleaseDateStatusEndpoint,
    ReportEndpoint,
    ReportTypeEndpoint,
    ScreenshotEndpoint,
    SearchEndpoint,
    ThemeEndpoint,
    WebsiteEndpoint,
    WebsiteTypeEndpoint
};
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class EndpointTest extends TestCase
{
    private ClientInterface $client;

    public function setup(): void {

        $this->client = Mockery::mock(ClientInterface::class);
        parent::setup();
    }

    public function tearDown(): void {

        Mockery::close();
        parent::tearDown();
    }

    #[DataProvider('endpointUrlProvider')]
    public function testShouldReturnCorrectEndpointURLWhenAskingEndpointName(string $fqn, string $url): void
    {
        $endpoint = $this->getMockForFQNEndpoint($fqn);
        $this->assertEquals($url, $endpoint->getEndpoint());
    }

    #[DataProvider('endpointProvider')]
    public function testShouldReturnObjectWhenUsingFindById(string $fqn): void
    {
        $endpoint = $this->getMockForFQNEndpoint($fqn);
        $this->client->shouldReceive('request')->andReturn(new Response(200, [], '[{"id": 1}]'));
        $response = $endpoint->findById(1, ['id']);
        $this->assertEquals((object) ['id' => 1], $response);
    }

    #[DataProvider('endpointProvider')]
    public function testShouldReturnNullWhenTryingToFindUnknownId(string $fqn): void
    {
        $endpoint = $this->getMockForFQNEndpoint($fqn);
        $this->client->shouldReceive('request')->andReturn(new Response(200, [], '[]'));
        $response = $endpoint->findById(10000000, ['id']);
        $this->assertNull($response);
    }

    #[DataProvider('endpointProvider')]
    public function testShouldReturnCollectionWhenListing(string $fqn): void
    {
        $endpoint = $this->getMockForFQNEndpoint($fqn);
        $this->client->shouldReceive('request')->andReturn(new Response(200, [], '[{"id": 1}, {"id": 2}]'));
        $response = $endpoint->list(0, 2, ['id']);
        $this->assertEquals(new Collection([(object) ['id' => 1], (object) ['id' => 2]]), $response);
    }

    #[DataProvider('endpointProvider')]
    public function testShouldReturnCollectionWhenUsingCustomQuery(string $fqn): void
    {
        $endpoint = $this->getMockForFQNEndpoint($fqn);
        $this->client->shouldReceive('request')->andReturn(new Response(200, [], '[{"id": 1}]'));
        $response = $endpoint->query('fields id; limit 1;');
        $this->assertEquals(new Collection([(object) ['id' => 1]]), $response);
    }


    #[DataProvider('endpointProvider')]
    public function testShouldReturnCollectionWithValidObjectsWhenUsingCustomQuery(string $fqn): void
    {
        $endpoint = $this->getMockForFQNEndpoint($fqn);
        $this->client->shouldReceive('request')->andReturn(new Response(200, [], '[{"id":1,"platforms":[{"id":5}]}]'));
        $response = $endpoint->query('fields id platforms.id; limit 1;');
        $this->assertEquals(new Collection([(object) ['id' => 1, 'platforms' => [(object) ['id' => 5]]]]), $response);
    }

    #[DataProvider('endpointProvider')]
    public function testShouldReturnAmountOfRecordsWhenCounting(string $fqn): void
    {
        $endpoint = $this->getMockForFQNEndpoint($fqn);
        $this->client->shouldReceive('request')->andReturn(new Response(200, [], '{"count": 42}'));
        $this->assertSame(42, $endpoint->count());
    }

    #[DataProvider('endpointUrlProvider')]
    public function testShouldPostQueryToCountingEndpointWhenCounting(string $fqn, string $url): void
    {
        $endpoint = $this->getMockForFQNEndpoint($fqn);

        $this->client
            ->shouldReceive('request')
            ->once()
            ->with('POST', 'https://api.igdb.com/v4/' . $url . '/count', Mockery::on(static fn (array $options): bool => 'where rating > 75;' === $options['body']))
            ->andReturn(new Response(200, [], '{"count": 7}'));

        $this->assertSame(7, $endpoint->count('where rating > 75;'));
    }

    #[DataProvider('endpointUrlProvider')]
    public function testShouldPostEmptyQueryToCountingEndpointWhenCountingWithoutQuery(string $fqn, string $url): void
    {
        $endpoint = $this->getMockForFQNEndpoint($fqn);

        $this->client
            ->shouldReceive('request')
            ->once()
            ->with('POST', 'https://api.igdb.com/v4/' . $url . '/count', Mockery::on(static fn (array $options): bool => '' === $options['body']))
            ->andReturn(new Response(200, [], '{"count": 155}'));

        $this->assertSame(155, $endpoint->count());
    }

    #[DataProvider('endpointProvider')]
    public function testShouldThrowExceptionWhenCountIsMissingFromCountResponse(string $fqn): void
    {
        $endpoint = $this->getMockForFQNEndpoint($fqn);
        $this->client->shouldReceive('request')->andReturn(new Response(200, [], '{}'));

        $this->expectException(RequestException::class);
        $endpoint->count();
    }

    #[DataProvider('endpointProvider')]
    public function testShouldThrowExceptionWhenCountResponseIsAList(string $fqn): void
    {
        $endpoint = $this->getMockForFQNEndpoint($fqn);
        $this->client->shouldReceive('request')->andReturn(new Response(200, [], '[]'));

        $this->expectException(RequestException::class);
        $endpoint->count();
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
        return array_map(static fn (array $row): array => [$row[0]], self::endpointUrlProvider());
    }

    public static function endpointUrlProvider(): array
    {
        return [
            [AgeRatingCategoryEndpoint::class, 'age_rating_categories'],
            [AgeRatingContentDescriptionEndpoint::class, 'age_rating_content_descriptions'],
            [AgeRatingContentDescriptionTypeEndpoint::class, 'age_rating_content_description_types'],
            [AgeRatingContentDescriptionV2Endpoint::class, 'age_rating_content_descriptions_v2'],
            [AgeRatingEndpoint::class, 'age_ratings'],
            [AgeRatingOrganizationEndpoint::class, 'age_rating_organizations'],
            [AlternativeNameEndpoint::class, 'alternative_names'],
            [ArtworkEndpoint::class, 'artworks'],
            [ArtworkTypeEndpoint::class, 'artwork_types'],
            [CharacterEndpoint::class, 'characters'],
            [CharacterGenderEndpoint::class, 'character_genders'],
            [CharacterMugShotEndpoint::class, 'character_mug_shots'],
            [CharacterSpeciesEndpoint::class, 'character_species'],
            [CollectionEndpoint::class, 'collections'],
            [CollectionMembershipEndpoint::class, 'collection_memberships'],
            [CollectionMembershipTypeEndpoint::class, 'collection_membership_types'],
            [CollectionRelationEndpoint::class, 'collection_relations'],
            [CollectionRelationTypeEndpoint::class, 'collection_relation_types'],
            [CollectionTypeEndpoint::class, 'collection_types'],
            [CompanyEndpoint::class, 'companies'],
            [CompanyLogoEndpoint::class, 'company_logos'],
            [CompanySizeEndpoint::class, 'company_sizes'],
            [CompanyStatusEndpoint::class, 'company_statuses'],
            [CompanyTypeEndpoint::class, 'company_types'],
            [CompanyTypeHistoryEndpoint::class, 'company_type_histories'],
            [CompanyWebsiteEndpoint::class, 'company_websites'],
            [CoverEndpoint::class, 'covers'],
            [DateFormatEndpoint::class, 'date_formats'],
            [EntityTypeEndpoint::class, 'entity_types'],
            [EventEndpoint::class, 'events'],
            [EventLogoEndpoint::class, 'event_logos'],
            [EventNetworkEndpoint::class, 'event_networks'],
            [ExternalGameEndpoint::class, 'external_games'],
            [ExternalGameSourceEndpoint::class, 'external_game_sources'],
            [FranchiseEndpoint::class, 'franchises'],
            [GameEndpoint::class, 'games'],
            [GameEngineEndpoint::class, 'game_engines'],
            [GameEngineLogoEndpoint::class, 'game_engine_logos'],
            [GameLocalizationEndpoint::class, 'game_localizations'],
            [GameModeEndpoint::class, 'game_modes'],
            [GameReleaseFormatEndpoint::class, 'game_release_formats'],
            [GameStatusEndpoint::class, 'game_statuses'],
            [GameTimeToBeatEndpoint::class, 'game_time_to_beats'],
            [GameTypeEndpoint::class, 'game_types'],
            [GameVersionEndpoint::class, 'game_versions'],
            [GameVersionFeatureEndpoint::class, 'game_version_features'],
            [GameVersionFeatureValueEndpoint::class, 'game_version_feature_values'],
            [GameVideoEndpoint::class, 'game_videos'],
            [GenreEndpoint::class, 'genres'],
            [ImageTypeEndpoint::class, 'image_types'],
            [InvolvedCompanyEndpoint::class, 'involved_companies'],
            [KeywordEndpoint::class, 'keywords'],
            [LanguageEndpoint::class, 'languages'],
            [LanguageSupportEndpoint::class, 'language_supports'],
            [LanguageSupportTypeEndpoint::class, 'language_support_types'],
            [MultiplayerModeEndpoint::class, 'multiplayer_modes'],
            [NetworkTypeEndpoint::class, 'network_types'],
            [PlatformEndpoint::class, 'platforms'],
            [PlatformFamilyEndpoint::class, 'platform_families'],
            [PlatformLogoEndpoint::class, 'platform_logos'],
            [PlatformTypeEndpoint::class, 'platform_types'],
            [PlatformVersionCompanyEndpoint::class, 'platform_version_companies'],
            [PlatformVersionEndpoint::class, 'platform_versions'],
            [PlatformVersionReleaseDateEndpoint::class, 'platform_version_release_dates'],
            [PlatformWebsiteEndpoint::class, 'platform_websites'],
            [PlayerPerspectiveEndpoint::class, 'player_perspectives'],
            [PopularityPrimitiveEndpoint::class, 'popularity_primitives'],
            [PopularityTypeEndpoint::class, 'popularity_types'],
            [RegionEndpoint::class, 'regions'],
            [ReleaseDateEndpoint::class, 'release_dates'],
            [ReleaseDateRegionEndpoint::class, 'release_date_regions'],
            [ReleaseDateStatusEndpoint::class, 'release_date_statuses'],
            [ReportEndpoint::class, 'reports'],
            [ReportTypeEndpoint::class, 'report_types'],
            [ScreenshotEndpoint::class, 'screenshots'],
            [SearchEndpoint::class, 'search'],
            [ThemeEndpoint::class, 'themes'],
            [WebsiteEndpoint::class, 'websites'],
            [WebsiteTypeEndpoint::class, 'website_types'],
        ];
    }
}