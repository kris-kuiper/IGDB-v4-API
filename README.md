IGDB V4 PHP API
====================

[![License](https://poser.pugx.org/kris-kuiper/igdbv4/license)](https://packagist.org/packages/kris-kuiper/igdbv4)
[![Total Downloads](https://poser.pugx.org/kris-kuiper/igdbv4/downloads)](https://packagist.org/packages/kris-kuiper/igdbv4)

## Introduction
This package is a PHP wrapper for the IGDB version 4 API for retrieving game information. It contains the following:
- All the IGDB v4 [endpoints](https://api-docs.igdb.com/?shell#endpoints)
- Authentication package for retrieving the access token
- Advanced query builder
- [Webhook](https://api-docs.igdb.com/?shell#webhooks) management and incoming notification handling

***

### System Requirements
Requires PHP 8.4 or later; Using the latest PHP version whenever possible is recommended.
The HTTP client is Guzzle: both `^7.15.2` and `^8.0` are supported. Anywhere this readme constructs a `GuzzleHttp\Client`, any `GuzzleHttp\ClientInterface` implementation will do.

***

### Installation
Run the following to install this package:
```bash
$ composer require kris-kuiper/igdbv4
```

***

### Authentication
To use the IGDB API you must have a Client ID and Access Token.
Full information regarding acquiring these can be found at https://dev.twitch.tv/docs/authentication.

However, to get started immediately:

- Sign Up with [Twitch](https://www.twitch.tv) for a free account
- [Register](https://dev.twitch.tv/console/apps/create) your application
- [Manage](https://dev.twitch.tv/console/apps) your newly created application
- Generate a Client Secret by pressing [New Secret]
- Take note of the Client ID and Client Secret

When you got the Client ID and Client Secret, you can use the `Authentication` class to get an access token.

#### Example retrieving the access token
```php
use KrisKuiper\IGDBV4\Authentication\AuthConfig;
use KrisKuiper\IGDBV4\Authentication\Authentication;
use GuzzleHttp\Client;

$config = new AuthConfig('your client id', 'your secret');
$client = new Client();
$authentication = new Authentication($client, $config);
$token = $authentication->obtainToken();

//The token will hold all the information you need to create a request to the IGDB API
$token->getAccessToken(); 
$token->getExpiration(); //The amount of seconds this token is valid
```

*Note: An access token is approximately valid for 60 days. It is recommended to save the access token and expiration time for later use, so there is no need to generate a new access token for every request.*

***

### Endpoints
Every endpoint listed can be request by calling the endpoints name and has the following methods:
- `findById()` - Find an item by its identifier (i.e. find a game by id)
- `list()` - Returns a list of items (i.e. list all screenshots of a specific game)
- `query()` - Execute a raw query on the current endpoint (i.e. execute a custom query to find a specific genre)
- `count()` - Returns how many items match a query, without fetching them (i.e. count all games with a rating above 75)

Only the game, platform, collection, character and theme endpoints supports also the `search()` method.

Below is a list of the supported endpoints.

|                                                                                                             |                                                                                           |                                                                                                 |
|-------------------------------------------------------------------------------------------------------------|-------------------------------------------------------------------------------------------|-------------------------------------------------------------------------------------------------|
| [Age rating](https://api-docs.igdb.com/?shell#age-rating)                                                   | [Date format](https://api-docs.igdb.com/?shell#date-format)                               | [Language support type](https://api-docs.igdb.com/?shell#language-support-type)                 |
| [Age rating category](https://api-docs.igdb.com/?shell#age-rating-category)                                 | [Entity type](https://api-docs.igdb.com/?shell#entity-type)                               | [Multiplayer mode](https://api-docs.igdb.com/?shell#multiplayer-mode)                           |
| [Age rating content description](https://api-docs.igdb.com/?shell#age-rating-content-description)           | [Event](https://api-docs.igdb.com/?shell#event)                                           | [Network type](https://api-docs.igdb.com/?shell#network-type)                                   |
| [Age rating content description type](https://api-docs.igdb.com/?shell#age-rating-content-description-type) | [Event logo](https://api-docs.igdb.com/?shell#event-logo)                                 | [Platform](https://api-docs.igdb.com/?shell#platform)                                           |
| [Age rating content description v2](https://api-docs.igdb.com/?shell#age-rating-content-description-v2)     | [Event network](https://api-docs.igdb.com/?shell#event-network)                           | [Platform family](https://api-docs.igdb.com/?shell#platform-family)                             |
| [Age rating organization](https://api-docs.igdb.com/?shell#age-rating-organization)                         | [External game](https://api-docs.igdb.com/?shell#external-game)                           | [Platform logo](https://api-docs.igdb.com/?shell#platform-logo)                                 |
| [Alternative name](https://api-docs.igdb.com/?shell#alternative-name)                                       | [External game source](https://api-docs.igdb.com/?shell#external-game-source)             | [Platform type](https://api-docs.igdb.com/?shell#platform-type)                                 |
| [Artwork](https://api-docs.igdb.com/?shell#artwork)                                                         | [Franchise](https://api-docs.igdb.com/?shell#franchise)                                   | [Platform version](https://api-docs.igdb.com/?shell#platform-version)                           |
| [Artwork type](https://api-docs.igdb.com/?shell#artwork-type)                                               | [Game](https://api-docs.igdb.com/?shell#game)                                             | [Platform version company](https://api-docs.igdb.com/?shell#platform-version-company)           |
| [Character](https://api-docs.igdb.com/?shell#character)                                                     | [Game engine](https://api-docs.igdb.com/?shell#game-engine)                               | [Platform version release date](https://api-docs.igdb.com/?shell#platform-version-release-date) |
| [Character gender](https://api-docs.igdb.com/?shell#character-gender)                                       | [Game engine logo](https://api-docs.igdb.com/?shell#game-engine-logo)                     | [Platform website](https://api-docs.igdb.com/?shell#platform-website)                           |
| [Character mug shot](https://api-docs.igdb.com/?shell#character-mug-shot)                                   | [Game localization](https://api-docs.igdb.com/?shell#game-localization)                   | [Player perspective](https://api-docs.igdb.com/?shell#player-perspective)                       |
| [Character species](https://api-docs.igdb.com/?shell#character-specie)                                      | [Game mode](https://api-docs.igdb.com/?shell#game-mode)                                   | [Popularity primitive](https://api-docs.igdb.com/?shell#popularity-primitive)                   |
| [Collection](https://api-docs.igdb.com/?shell#collection)                                                   | [Game release format](https://api-docs.igdb.com/?shell#game-release-format)               | [Popularity type](https://api-docs.igdb.com/?shell#popularity-type)                             |
| [Collection membership](https://api-docs.igdb.com/?shell#collection-membership)                             | [Game status](https://api-docs.igdb.com/?shell#game-status)                               | [Region](https://api-docs.igdb.com/?shell#region)                                               |
| [Collection membership type](https://api-docs.igdb.com/?shell#collection-membership-type)                   | [Game time to beat](https://api-docs.igdb.com/?shell#game-time-to-beat)                   | [Release date](https://api-docs.igdb.com/?shell#release-date)                                   |
| [Collection relation](https://api-docs.igdb.com/?shell#collection-relation)                                 | [Game type](https://api-docs.igdb.com/?shell#game-type)                                   | [Release date region](https://api-docs.igdb.com/?shell#release-date-region)                     |
| [Collection relation type](https://api-docs.igdb.com/?shell#collection-relation-type)                       | [Game version](https://api-docs.igdb.com/?shell#game-version)                             | [Release date status](https://api-docs.igdb.com/?shell#release-date-status)                     |
| [Collection type](https://api-docs.igdb.com/?shell#collection-type)                                         | [Game version feature](https://api-docs.igdb.com/?shell#game-version-feature)             | [Report](https://api-docs.igdb.com/?shell#report)                                               |
| [Company](https://api-docs.igdb.com/?shell#company)                                                         | [Game version feature value](https://api-docs.igdb.com/?shell#game-version-feature-value) | [Report type](https://api-docs.igdb.com/?shell#report-type)                                     |
| [Company logo](https://api-docs.igdb.com/?shell#company-logo)                                               | [Game video](https://api-docs.igdb.com/?shell#game-video)                                 | [Screenshot](https://api-docs.igdb.com/?shell#screenshot)                                       |
| [Company size](https://api-docs.igdb.com/?shell#company-size)                                               | [Genre](https://api-docs.igdb.com/?shell#genre)                                           | [Search](https://api-docs.igdb.com/?shell#search)                                               |
| [Company status](https://api-docs.igdb.com/?shell#company-status)                                           | [Image type](https://api-docs.igdb.com/?shell#image-type)                                 | [Theme](https://api-docs.igdb.com/?shell#theme)                                                 |
| [Company type](https://api-docs.igdb.com/?shell#company-type)                                               | [Involved company](https://api-docs.igdb.com/?shell#involved-company)                     | [Website](https://api-docs.igdb.com/?shell#website)                                             |
| [Company type history](https://api-docs.igdb.com/?shell#company-type-history)                               | [Keyword](https://api-docs.igdb.com/?shell#keyword)                                       | [Website type](https://api-docs.igdb.com/?shell#website-type)                                   |
| [Company website](https://api-docs.igdb.com/?shell#company-website)                                         | [Language](https://api-docs.igdb.com/?shell#language)                                     |                                                                                                 |
| [Cover](https://api-docs.igdb.com/?shell#cover)                                                             | [Language support](https://api-docs.igdb.com/?shell#language-support)                     |                                                                                                 |

Two of these are deprecated by IGDB and kept only so existing code keeps working: `ageRatingContentDescription()` (use `ageRatingContentDescriptionV2()` instead) and `artworkType()` (use `imageType()` instead).

#### Example fetching game(s), platform(s) and genre(s):
```php
use GuzzleHttp\Client;
use KrisKuiper\IGDBV4\IGDB;
use KrisKuiper\IGDBV4\Authentication\ValueObjects\AccessConfig;

$client = new Client();
$config = new AccessConfig('your client id', 'your access token');
$igdb = new IGDB($client, $config);

//Games
$igdb->game()->findById(375); //Find a game by id with optional selecting fields
$igdb->game()->findById(375, ['name', 'storyline', 'platforms.*']); //Find a game by id and specifying the fields to return
$igdb->game()->search('Metal Gear Solid'); //Search games by title
$igdb->game()->search('Metal Gear Solid', ['name', 'storyline', 'platforms.*']); //Search games by title and specifying the fields to return
$igdb->game()->list(); //List all games (limit will be 500 as default)
$igdb->game()->list(50, 20); //Setting an offset and limit (for pagination purposes)
$igdb->game()->query('fields name, storyline, platforms.*; where platforms = (7,9); sort id asc; limit 50'); //Using a custom query (see the Advanced Query builder section for creating queries programmatically)
$igdb->game()->count(); //Count all games
$igdb->game()->count('where rating > 75;'); //Count all games matching a filter

//Platforms
$igdb->platform()->findById(5, ['name', 'slug']);
$igdb->platform()->list();
$igdb->platform()->search('Playstation');
$igdb->platform()->query('fields name, slug; limit 500; sort id;');

//Genres
$igdb->genre()->findById(5, ['name', 'slug']);
$igdb->genre()->list();
$igdb->genre()->query('fields name, slug; limit 500; sort id;');
```

*Note: All the listed endpoints are available through the `IGDB` class.*

***

### Counting
Every endpoint has a counting variant that reports how many items match a filter, so there is no need to page through a list to find out. Call `count()` with an [apicalypse](https://api-docs.igdb.com/#apicalypse-1) query, or without one to count everything on the endpoint.

```php
$igdb->game()->count(); //Count all games
$igdb->game()->count('where rating > 75;'); //Count all games with a rating above 75
$igdb->platform()->count('where platform_type = 1;'); //Count all platforms of a given type
```

Only the filters are meaningful while counting: selecting fields, sorting and paginating have nothing to act on. A query built for a list call can be passed in unchanged, but a filter is all that is needed:

```php
use KrisKuiper\IGDBV4\QueryBuilder\Query;

//where platforms = (7, 9) & genres != 45;
$query = (new Query())
    ->where('platforms', [7, 9])
    ->where('genres', 45, '!=')
    ->build();

$igdb->game()->count($query);
```

***

### Advanced Query Builder
The query builder lets you programmatically create queries which you can use for each endpoint calling the `query()` method.

It contains the following methods:
- `fields()` (selecting specific fields)
- `exclude()` (excluding specific fields)
- `search()` 
- `where()` (where, whereIn and grouping where's)
- `orWhere()` (only after a where)
- `sort()`
- `offset()`
- `limit()`

#### Example using the query builder with the "games" endpoint
```php
use GuzzleHttp\Client;
use KrisKuiper\IGDBV4\IGDB;
use KrisKuiper\IGDBV4\Authentication\ValueObjects\AccessConfig;
use KrisKuiper\IGDBV4\QueryBuilder\Query;

$client = new Client();
$config = new AccessConfig('your client id', 'your access token');
$igdb = new IGDB($client, $config);

//fields name, storyline, platforms.*; where platforms = (7, 9) & genres != 45; sort id asc; limit 20;
$query = (new Query())
    ->fields('name', 'storyline', 'platforms.*')
    ->where('platforms', [7, 9])
    ->where('genres', 45, '!=')
    ->sort('id')
    ->limit(20)
    ->build();
    
$igdb->game()->query($query);
```

#### Examples using the query builder
```php
use KrisKuiper\IGDBV4\QueryBuilder\Query;

//fields name, storyline; platforms.*; where id = 375;
$query = (new Query())
    ->fields('name', 'storyline', 'platforms.*')
    ->where('id', 375)
    ->build();
    
//fields name, storyline; search "Metal Gear Solid; limit 50;
$query = (new Query())
    ->fields('name', 'storyline', 'platforms.*')
    ->search('Metal Gear Solid')
    ->limit(50)
    ->build();

//fields *; exclude genres, platforms, keywords; sort name desc; limit 50;
$query = (new Query())
    ->fields('*')
    ->exclude('genres', 'platforms', 'keywords')
    ->limit(50)
    ->sort('name', 'desc')
    ->build();
```

#### Query builder advanced where conditions
```php
use KrisKuiper\IGDBV4\QueryBuilder\Query;

//fields name; where genres = 25 & platforms = 5;
$query = (new Query())
    ->fields('name')
    ->where('genres', 25)
    ->where('platforms', 5)
    ->build();

//fields name; where platforms >= 5 & platforms <= 10;
$query = (new Query())
    ->fields('name')
    ->where('platforms', 5, '>=')
    ->where('platforms', 10, '<=')
    ->build();
    
//fields name; where genres = 25 | platforms = (5, 7, 9);
$query = (new Query())
    ->fields('name')
    ->where('genres', 25)
    ->orWhere('platforms', [5, 7, 9])
    ->build();

//fields name; where genres = 25 | (platforms = 5 | platforms = 9 | platforms = 12) & id = 375;
$query = (new Query())
    ->fields('name')
    ->where('genres', 25)
    ->orWhere(function($query) {
        $query
            ->where('platforms', 5)
            ->orWhere('platforms', 9)
            ->orWhere('platforms', 12);
    })
    ->where('id', 375)
    ->build();
```

***

### Webhooks
Instead of polling the API for changes, IGDB can push data to you whenever an entity is added, updated or deleted. This package supports both **managing** your webhooks and **handling** the incoming notifications.

Full information can be found in the IGDB [webhook documentation](https://api-docs.igdb.com/?shell#webhooks).

#### Managing webhooks
Webhooks are registered per endpoint and per method (`create`, `update` or `delete`). The `secret` is a value of your choice that IGDB will send back in the `X-Secret` header of every notification, so you can verify the request really came from IGDB.

```php
use GuzzleHttp\Client;
use KrisKuiper\IGDBV4\IGDB;
use KrisKuiper\IGDBV4\Authentication\ValueObjects\AccessConfig;
use KrisKuiper\IGDBV4\Enums\WebhookMethod;

$client = new Client();
$config = new AccessConfig('your client id', 'your access token');
$igdb = new IGDB($client, $config);

//Register a webhook that fires when a new game is created
$webhook = $igdb->webhooks()->register('games', 'https://example.com/igdb/webhook', WebhookMethod::CREATE, 'your-secret');
$webhook->getId();      //The unique webhook id
$webhook->isActive();   //Whether the webhook is currently active

//Retrieve all registered webhooks (returns a typed WebhookCollection)
foreach ($igdb->webhooks()->all() as $webhook) {
    $webhook->getUrl();
}

//Retrieve a single webhook by its id (returns null when it does not exist)
$igdb->webhooks()->find($webhook->getId());

//Send a test notification: delivers the game with id 1337 to your registered "games" create webhook
$igdb->webhooks()->test('games', $webhook->getId(), 1337);

//Remove a webhook (returns the deleted webhook id)
$igdb->webhooks()->delete($webhook->getId());
```

*Tip: A webhook is set to inactive after 5 failed deliveries. Re-register it on service start to make sure it is always active.*

#### Handling incoming notifications
When IGDB delivers a notification, validate and parse it with the `WebhookReceiver`. It is framework-agnostic and accepts any PSR-7 `ServerRequestInterface`. It verifies the `X-Secret` and `User-Agent` headers for you and throws a `WebhookException` when the request can not be trusted.

```php
use KrisKuiper\IGDBV4\Webhooks\WebhookReceiver;
use KrisKuiper\IGDBV4\Exceptions\WebhookException;
use KrisKuiper\IGDBV4\Enums\WebhookMethod;

//$request is a PSR-7 ServerRequestInterface provided by your framework
$receiver = new WebhookReceiver('your-secret');

try {
    $payload = $receiver->receive($request);
} catch (WebhookException $exception) {
    //Invalid secret, wrong user agent or an unparsable body: reject the request
    http_response_code(403);
    return;
}

$payload->getEndpoint();    //e.g. "games"
$payload->getOperation();   //WebhookMethod::CREATE, ::UPDATE or ::DELETE
$payload->getId();          //The id of the affected entity
$payload->getData();        //The unexpanded entity (only the id is present for delete notifications)

//Always answer within 15 seconds with a 200 OK so IGDB keeps the webhook active
http_response_code(200);
```

*Note: incoming `X-Endpoint` values are normalized to their lowercase slug (IGDB delivers `Games` while webhooks are registered as `games`), and the `X-Operation` value is matched case-insensitively.*

#### Handling test deliveries
Deliveries triggered through the test API (`$igdb->webhooks()->test(...)`) differ from real deliveries: IGDB sends them with a generic `Java/<version>` user agent and **without** the `X-Endpoint` and `X-Operation` headers (the `X-Secret` header is present). They would therefore always be rejected by `receive()`. Use `receiveTest()` instead, which only verifies the secret and returns the raw entity:

```php
$receiver = new WebhookReceiver('your-secret');
$data = $receiver->receiveTest($request); //Verifies X-Secret, returns the entity object
$data->id;
```

***

### Run Unit Test
Install phpunit in your environment and run:

```bash
$ php ./vendor/bin/phpunit
```

***

### Questions and Feedback
Questions that are not addressed in the manual should be directed to the
relevant repository, as linked above.

If you find code in this release behaving in an unexpected manner or
contrary to its documented behavior, please create an issue with the relevant
repository, as linked above.

***

### License
You can find a copy of this license in [LICENSE.md](LICENSE.md).