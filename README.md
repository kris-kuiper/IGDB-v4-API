IGDB V4 PHP API
====================

## Introduction
This package is a PHP wrapper for the IGDB version 4 API for retrieving game information. It contains the following:
- All the IGDB v4 [endpoints](https://api-docs.igdb.com/?shell#endpoints)
- Authentication package for retrieving the access token
- Advanced query builder

***

### System Requirements
Requires PHP 8.0 or later; Using the latest PHP version whenever possible is recommended.

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

Only the game, platform, collection, character and theme endpoints supports also the `search()` method.

Below is a list of the supported endpoints.

|   |   |   |
|---|---|---|
| [Age rating content description](https://api-docs.igdb.com/?shell#age-rating-content-description)  | [Game](https://api-docs.igdb.com/?shell#game)  | [Platform family](https://api-docs.igdb.com/?shell#platform-family)  |
| [Age rating](https://api-docs.igdb.com/?shell#age-rating)  | [Game engine](https://api-docs.igdb.com/?shell#game-engine)  | [Platform logo](https://api-docs.igdb.com/?shell#platform-logo)  |
| [Alternative name](https://api-docs.igdb.com/?shell#alternative-name)  | [Game engine logo](https://api-docs.igdb.com/?shell#game-engine-logo)  | [Platform version company](https://api-docs.igdb.com/?shell#platform-version-company)  |
| [Artwork](https://api-docs.igdb.com/?shell#artwork)  | [Game mode](https://api-docs.igdb.com/?shell#game-mode)  | [Platform version](https://api-docs.igdb.com/?shell#platform-version)  |
| [Character](https://api-docs.igdb.com/?shell#character)  | [Game version](https://api-docs.igdb.com/?shell#game-version)  | [Platform version release date](https://api-docs.igdb.com/?shell#platform-version-release-date)  |
| [Character mug shot](https://api-docs.igdb.com/?shell#character-mug-shot)  | [Game version feature](https://api-docs.igdb.com/?shell#game-version-feature)  | [Platform website](https://api-docs.igdb.com/?shell#platform-website)  |
| [Collection](https://api-docs.igdb.com/?shell#collection)  | [Game version feature value](https://api-docs.igdb.com/?shell#game-version-feature-value)  | [Player perspective](https://api-docs.igdb.com/?shell#player-perspective)  |
| [Company](https://api-docs.igdb.com/?shell#company)  | [Game video](https://api-docs.igdb.com/?shell#game-video)  | [Screenshot](https://api-docs.igdb.com/?shell#screenshot)  |
| [Company logo](https://api-docs.igdb.com/?shell#company-logo)  | [Genre](https://api-docs.igdb.com/?shell#genre)  | [Search](https://api-docs.igdb.com/?shell#search)  |
| [Company website](https://api-docs.igdb.com/?shell#company-website)  | [Involved company](https://api-docs.igdb.com/?shell#involved-company)  | [Theme](https://api-docs.igdb.com/?shell#theme)  |
| [Cover](https://api-docs.igdb.com/?shell#cover)  | [Keyword](https://api-docs.igdb.com/?shell#keyword)  | [Website](https://api-docs.igdb.com/?shell#website)  |
| [External game](https://api-docs.igdb.com/?shell#external-game)  | [Multiplayer mode](https://api-docs.igdb.com/?shell#multiplayer-mode)  | 
| [Franchise](https://api-docs.igdb.com/?shell#franchise)  | [Platform](https://api-docs.igdb.com/?shell#platform)  |   

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

### Advanced Query Builder
The query builder lets you programmatically create queries which you can use for each endpoint calling the `query()` method.

It contains the following methods:
- fields
- exclude
- search
- where
- orWhere (only after a where)
- sort
- offset
- limit

#### Example using the query builder with the "games" endpoint
```php
use GuzzleHttp\Client;
use KrisKuiper\IGDBV4\IGDB;
use KrisKuiper\IGDBV4\Authentication\ValueObjects\AccessConfig;
use KrisKuiper\IGDBV4\QueryBuilder\Query;

$client = new Client();
$config = new AccessConfig('your client id', 'your access token');
$igdb = new IGDB($client, $config);

//fields name, storyline, platforms.*; where platforms = (7, 9) & genre != 45; sort id asc; limit 20;
$query = (new Query())
    ->fields('name', 'storyline', 'platforms.*')
    ->where('platforms', [7, 9])
    ->where('genre', 45, '!=')
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

//fields *; exclude genre, platforms, keywords; sort name desc; limit 50;
$query = (new Query())
    ->fields('*')
    ->exclude('genre', 'platform', 'keywords')
    ->limit(50)
    ->sort('name', 'desc')
    ->build();
```

#### Query builder advanced where conditions
```php
use KrisKuiper\IGDBV4\QueryBuilder\Query;

//fields name; where genre = 25 & platforms = 5;
$query = (new Query())
    ->fields('name')
    ->where('genre', 25)
    ->where('platforms', 5)
    ->build();

//fields name; where platforms >= 5 & platforms <= 10;
$query = (new Query())
    ->fields('name')
    ->where('platforms', 5, '>=')
    ->where('platforms', 10, '<=')
    ->build();
    
//fields name; where genre = 25 | platforms = (5, 7, 9);
$query = (new Query())
    ->fields('name')
    ->where('genre', 25)
    ->orWhere('platforms', [5, 7, 9])
    ->build();

//fields name; where genre = 25 | (platforms = 5 | platforms = 9 | platforms = 12) & id = 375;
$query = (new Query())
    ->fields('name')
    ->where('genre', 25)
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

### Run Unit Test
Install phpunit in your environment and run:

```bash
$ php /vendor/bin/phpunit
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