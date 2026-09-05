# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.3.0] - 2026-09-05

### Added
- `count()` on every endpoint (and on `EndpointInterface`), returning how many records
  match a query without fetching them. It posts the given apicalypse body to the
  counting variant of the endpoint (`POST /v4/<endpoint>/count`) and returns the
  reported number; without a query it counts everything on the endpoint. Only the
  filters of a query are meaningful while counting, so a query built for a list call
  can be passed in unchanged.
- Support for Guzzle 8 next to Guzzle 7. Nothing in this package depends on behaviour
  specific to either major; the suite runs green on both.
- The 40 endpoints IGDB has added since the package was last completed, bringing the
  coverage to all 79 documented endpoints. Among them are the endpoints the deprecated
  fields point at: `game_types`, `platform_types`, `character_genders`,
  `character_species`, `date_formats`, `external_game_sources`, `game_release_formats`,
  `game_statuses`, `website_types`, `image_types`, `age_rating_organizations`,
  `age_rating_categories` and `age_rating_content_descriptions_v2`.

### Changed
- Widened `guzzlehttp/guzzle` to `^7.15.2 || ^8.0`. The floor was raised from `^7.11`
  because 7.11 through 7.15.1 carry the advisories fixed in 7.15.2.
- The constructors of `IGDB`, `Authentication`, `WebhookService`, the endpoints and the
  requests accept a `GuzzleHttp\ClientInterface` instead of the concrete
  `GuzzleHttp\Client`, so the package is no longer tied to one implementation. Passing a
  `Client` keeps working; only a subclass that narrows the parameter back to `Client`
  in an overridden constructor would have to widen it.
- A response to a counting request without a `count` throws `RequestException` rather
  than counting as zero.

### Deprecated
- `IGDB::ageRatingContentDescription()` and its endpoint: IGDB replaced it with
  `age_rating_content_descriptions_v2`, reachable through
  `IGDB::ageRatingContentDescriptionV2()`.
- `IGDB::artworkType()` and its endpoint: IGDB replaced it with `image_types`,
  reachable through `IGDB::imageType()`. Both are kept so existing code keeps working.

### Fixed
- The endpoint table in the readme was missing `release_dates` and
  `release_date_regions`, and the query builder examples filtered on `genre` and
  `platform` while the fields on a game are `genres` and `platforms`.

## [2.2.0] - 2026-07-16

### Added
- The `release_date_regions` endpoint, through `IGDB::releaseDateRegion()`.

## [2.1.0] - 2026-06-04

### Added
- `WebhookReceiver::receiveTest()` (also on `WebhookReceiverInterface`) for handling
  IGDB test deliveries. The test API delivers with a generic `Java/<version>` user
  agent and without the `X-Endpoint`/`X-Operation` headers, so `receive()` would
  always reject them; `receiveTest()` verifies only the `X-Secret` header and
  returns the raw entity.

### Fixed
- `WebhookService::register()` threw `Expected the key "id" to exist.` while the
  webhook was created: IGDB wraps the created webhook in a one-element list, like
  the list response. Single-object responses are now normalized through one shared
  code path for `register()` and `find()`.
- Incoming `X-Endpoint` values are normalized to their lowercase slug
  (IGDB delivers `Games` while webhooks are registered as `games`), so
  `WebhookPayload::getEndpoint()` matches the registered endpoint.
- `WebhookMethod::fromOperation()` now matches the `X-Operation` header
  case-insensitively.

## [2.0.1] - 2026-06-04

### Changed
- Bumped `webmozart/assert` to `^2.0` (was `^1.11`). The 2.x API is compatible
  (`Assert::keyExists()` unchanged) and requires PHP 8.2+, which fits the
  `>=8.4` requirement.

## [2.0.0] - 2026-06-04

### Added
- IGDB webhook support:
  - Webhook management through `IGDB::webhooks()` (`WebhookService`): `register()`,
    `all()`, `find()`, `delete()` and `test()`.
  - Incoming notification handling through `WebhookReceiver` (framework-agnostic,
    PSR-7), verifying the `X-Secret` and `User-Agent` headers and parsing the payload.
  - New `WebhookMethod` enum, `Webhook` and `WebhookPayload` value objects,
    `WebhookCollection` typed collection and `WebhookException` domain exception.

### Changed
- **BC** Raised the minimum PHP version from `>=8.0` to `>=8.4`.
- **BC** `Token::fromArray()` now throws `\InvalidArgumentException` instead of
  `Assert\AssertionFailedException`. Behaviour through `Authentication::obtainToken()`
  is unchanged (it still throws `AuthenticationException`).
- Replaced the abandoned `beberlei/assert` dependency with `webmozart/assert`.
- Upgraded Guzzle to `^7.11`.
- Extracted the shared HTTP logic into an `AbstractRequest` base class.
- Made nullable parameter types explicit (`?array $fields = null`) for PHP 8.4
  compatibility.

### Developer experience
- Upgraded dev tooling: PHPUnit `^13`, PHPStan `^2`, PHP_CodeSniffer `^4`,
  slevomat/coding-standard `^8.18`, grumphp-shim `^2.21`.
- Removed `brianium/paratest` (no PHPUnit 13 compatible release); tests now run
  through the GrumPHP `phpunit` task.
- Slimmed the Docker image down to `php:8.5-cli-bookworm` and cleaned up
  `docker-compose.yml` (this is a library, not a web application).

[2.3.0]: https://github.com/kris-kuiper/IGDB-v4-API/releases/tag/v2.3.0
[2.2.0]: https://github.com/kris-kuiper/IGDB-v4-API/releases/tag/v2.2.0
[2.1.0]: https://github.com/kris-kuiper/IGDB-v4-API/releases/tag/v2.1.0
[2.0.1]: https://github.com/kris-kuiper/IGDB-v4-API/releases/tag/v2.0.1
[2.0.0]: https://github.com/kris-kuiper/IGDB-v4-API/releases/tag/v2.0.0
