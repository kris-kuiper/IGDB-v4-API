<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4;

use GuzzleHttp\Client;
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
use KrisKuiper\IGDBV4\Contracts\AccessConfigInterface;
use KrisKuiper\IGDBV4\Contracts\EndpointInterface;
use KrisKuiper\IGDBV4\Contracts\EndpointSearchInterface;

class IGDB
{
    private Client $client;
    private AccessConfigInterface $config;

    public function __construct(Client $client, AccessConfigInterface $config)
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
}
