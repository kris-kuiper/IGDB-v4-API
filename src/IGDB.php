<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4;

use GuzzleHttp\ClientInterface;
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
use KrisKuiper\IGDBV4\Contracts\AccessConfigInterface;
use KrisKuiper\IGDBV4\Contracts\EndpointInterface;
use KrisKuiper\IGDBV4\Contracts\EndpointSearchInterface;
use KrisKuiper\IGDBV4\Contracts\WebhookServiceInterface;
use KrisKuiper\IGDBV4\Webhooks\WebhookService;

class IGDB
{
    private ClientInterface $client;
    private AccessConfigInterface $config;

    public function __construct(ClientInterface $client, AccessConfigInterface $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    public function alternativeName(): EndpointInterface
    {
        return new AlternativeNameEndpoint($this->client, $this->config);
    }

    public function artwork(): EndpointInterface
    {
        return new ArtworkEndpoint($this->client, $this->config);
    }

    /**
     * @deprecated IGDB deprecated this endpoint in favour of ageRatingContentDescriptionV2().
     */
    public function ageRatingContentDescription(): EndpointInterface
    {
        return new AgeRatingContentDescriptionEndpoint($this->client, $this->config);
    }

    public function collection(): EndpointSearchInterface
    {
        return new CollectionEndpoint($this->client, $this->config);
    }

    public function character(): EndpointSearchInterface
    {
        return new CharacterEndpoint($this->client, $this->config);
    }

    public function company(): EndpointInterface
    {
        return new CompanyEndpoint($this->client, $this->config);
    }

    public function companyLogo(): EndpointInterface
    {
        return new CompanyLogoEndpoint($this->client, $this->config);
    }

    public function ageRating(): EndpointInterface
    {
        return new AgeRatingEndpoint($this->client, $this->config);
    }

    public function characterMugShot(): EndpointInterface
    {
        return new CharacterMugShotEndpoint($this->client, $this->config);
    }

    public function cover(): EndpointInterface
    {
        return new CoverEndpoint($this->client, $this->config);
    }

    public function companyWebsite(): EndpointInterface
    {
        return new CompanyWebsiteEndpoint($this->client, $this->config);
    }

    public function externalGame(): EndpointInterface
    {
        return new ExternalGameEndpoint($this->client, $this->config);
    }

    public function franchise(): EndpointInterface
    {
        return new FranchiseEndpoint($this->client, $this->config);
    }

    public function game(): EndpointSearchInterface
    {
        return new GameEndpoint($this->client, $this->config);
    }

    public function gameEngine(): EndpointInterface
    {
        return new GameEngineEndpoint($this->client, $this->config);
    }

    public function gameEngineLogo(): EndpointInterface
    {
        return new GameEngineLogoEndpoint($this->client, $this->config);
    }

    public function gameVersion(): EndpointInterface
    {
        return new GameVersionEndpoint($this->client, $this->config);
    }

    public function gameMode(): EndpointInterface
    {
        return new GameModeEndpoint($this->client, $this->config);
    }

    public function gameVideo(): EndpointInterface
    {
        return new GameVideoEndpoint($this->client, $this->config);
    }

    public function gameVersionFeatureValue(): EndpointInterface
    {
        return new GameVersionFeatureValueEndpoint($this->client, $this->config);
    }

    public function involvedCompany(): EndpointInterface
    {
        return new InvolvedCompanyEndpoint($this->client, $this->config);
    }

    public function genre(): EndpointInterface
    {
        return new GenreEndpoint($this->client, $this->config);
    }

    public function keyword(): EndpointInterface
    {
        return new KeywordEndpoint($this->client, $this->config);
    }

    public function gameVersionFeature(): EndpointInterface
    {
        return new GameVersionFeatureEndpoint($this->client, $this->config);
    }

    public function platform(): EndpointSearchInterface
    {
        return new PlatformEndpoint($this->client, $this->config);
    }

    public function platformFamily(): EndpointInterface
    {
        return new PlatformFamilyEndpoint($this->client, $this->config);
    }

    public function multiplayerMode(): EndpointInterface
    {
        return new MultiplayerModeEndpoint($this->client, $this->config);
    }

    public function platformVersionCompany(): EndpointInterface
    {
        return new PlatformVersionCompanyEndpoint($this->client, $this->config);
    }

    public function platformVersion(): EndpointInterface
    {
        return new PlatformVersionEndpoint($this->client, $this->config);
    }

    public function platformVersionReleaseDate(): EndpointInterface
    {
        return new PlatformVersionReleaseDateEndpoint($this->client, $this->config);
    }

    public function platformWebsite(): EndpointInterface
    {
        return new PlatformWebsiteEndpoint($this->client, $this->config);
    }

    public function playerPerspective(): EndpointInterface
    {
        return new PlayerPerspectiveEndpoint($this->client, $this->config);
    }

    public function releaseDate(): EndpointInterface
    {
        return new ReleaseDateEndpoint($this->client, $this->config);
    }

    public function releaseDateRegion(): EndpointInterface
    {
        return new ReleaseDateRegionEndpoint($this->client, $this->config);
    }

    public function platformLogo(): EndpointInterface
    {
        return new PlatformLogoEndpoint($this->client, $this->config);
    }

    public function search(): EndpointInterface
    {
        return new SearchEndpoint($this->client, $this->config);
    }

    public function theme(): EndpointSearchInterface
    {
        return new ThemeEndpoint($this->client, $this->config);
    }

    public function website(): EndpointInterface
    {
        return new WebsiteEndpoint($this->client, $this->config);
    }

    public function screenshot(): EndpointInterface
    {
        return new ScreenshotEndpoint($this->client, $this->config);
    }

    public function ageRatingCategory(): EndpointInterface
    {
        return new AgeRatingCategoryEndpoint($this->client, $this->config);
    }

    public function ageRatingContentDescriptionType(): EndpointInterface
    {
        return new AgeRatingContentDescriptionTypeEndpoint($this->client, $this->config);
    }

    public function ageRatingContentDescriptionV2(): EndpointInterface
    {
        return new AgeRatingContentDescriptionV2Endpoint($this->client, $this->config);
    }

    public function ageRatingOrganization(): EndpointInterface
    {
        return new AgeRatingOrganizationEndpoint($this->client, $this->config);
    }

    /**
     * @deprecated IGDB deprecated this endpoint in favour of the image type endpoint.
     */
    public function artworkType(): EndpointInterface
    {
        return new ArtworkTypeEndpoint($this->client, $this->config);
    }

    public function characterGender(): EndpointInterface
    {
        return new CharacterGenderEndpoint($this->client, $this->config);
    }

    public function characterSpecies(): EndpointInterface
    {
        return new CharacterSpeciesEndpoint($this->client, $this->config);
    }

    public function collectionMembershipType(): EndpointInterface
    {
        return new CollectionMembershipTypeEndpoint($this->client, $this->config);
    }

    public function collectionMembership(): EndpointInterface
    {
        return new CollectionMembershipEndpoint($this->client, $this->config);
    }

    public function collectionRelationType(): EndpointInterface
    {
        return new CollectionRelationTypeEndpoint($this->client, $this->config);
    }

    public function collectionRelation(): EndpointInterface
    {
        return new CollectionRelationEndpoint($this->client, $this->config);
    }

    public function collectionType(): EndpointInterface
    {
        return new CollectionTypeEndpoint($this->client, $this->config);
    }

    public function companySize(): EndpointInterface
    {
        return new CompanySizeEndpoint($this->client, $this->config);
    }

    public function companyStatus(): EndpointInterface
    {
        return new CompanyStatusEndpoint($this->client, $this->config);
    }

    public function companyTypeHistory(): EndpointInterface
    {
        return new CompanyTypeHistoryEndpoint($this->client, $this->config);
    }

    public function companyType(): EndpointInterface
    {
        return new CompanyTypeEndpoint($this->client, $this->config);
    }

    public function dateFormat(): EndpointInterface
    {
        return new DateFormatEndpoint($this->client, $this->config);
    }

    public function entityType(): EndpointInterface
    {
        return new EntityTypeEndpoint($this->client, $this->config);
    }

    public function eventLogo(): EndpointInterface
    {
        return new EventLogoEndpoint($this->client, $this->config);
    }

    public function eventNetwork(): EndpointInterface
    {
        return new EventNetworkEndpoint($this->client, $this->config);
    }

    public function event(): EndpointInterface
    {
        return new EventEndpoint($this->client, $this->config);
    }

    public function externalGameSource(): EndpointInterface
    {
        return new ExternalGameSourceEndpoint($this->client, $this->config);
    }

    public function gameLocalization(): EndpointInterface
    {
        return new GameLocalizationEndpoint($this->client, $this->config);
    }

    public function gameReleaseFormat(): EndpointInterface
    {
        return new GameReleaseFormatEndpoint($this->client, $this->config);
    }

    public function gameStatus(): EndpointInterface
    {
        return new GameStatusEndpoint($this->client, $this->config);
    }

    public function gameTimeToBeat(): EndpointInterface
    {
        return new GameTimeToBeatEndpoint($this->client, $this->config);
    }

    public function gameType(): EndpointInterface
    {
        return new GameTypeEndpoint($this->client, $this->config);
    }

    public function imageType(): EndpointInterface
    {
        return new ImageTypeEndpoint($this->client, $this->config);
    }

    public function languageSupportType(): EndpointInterface
    {
        return new LanguageSupportTypeEndpoint($this->client, $this->config);
    }

    public function languageSupport(): EndpointInterface
    {
        return new LanguageSupportEndpoint($this->client, $this->config);
    }

    public function language(): EndpointInterface
    {
        return new LanguageEndpoint($this->client, $this->config);
    }

    public function networkType(): EndpointInterface
    {
        return new NetworkTypeEndpoint($this->client, $this->config);
    }

    public function platformType(): EndpointInterface
    {
        return new PlatformTypeEndpoint($this->client, $this->config);
    }

    public function popularityPrimitive(): EndpointInterface
    {
        return new PopularityPrimitiveEndpoint($this->client, $this->config);
    }

    public function popularityType(): EndpointInterface
    {
        return new PopularityTypeEndpoint($this->client, $this->config);
    }

    public function region(): EndpointInterface
    {
        return new RegionEndpoint($this->client, $this->config);
    }

    public function releaseDateStatus(): EndpointInterface
    {
        return new ReleaseDateStatusEndpoint($this->client, $this->config);
    }

    public function reportType(): EndpointInterface
    {
        return new ReportTypeEndpoint($this->client, $this->config);
    }

    public function report(): EndpointInterface
    {
        return new ReportEndpoint($this->client, $this->config);
    }

    public function websiteType(): EndpointInterface
    {
        return new WebsiteTypeEndpoint($this->client, $this->config);
    }

    public function webhooks(): WebhookServiceInterface
    {
        return new WebhookService($this->client, $this->config);
    }
}
