# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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

[2.0.0]: https://github.com/kris-kuiper/IGDB-v4-API/releases/tag/v2.0.0
