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
Below is a list of the supported endpoints. Every endpoint listed can be request by calling the endpoints name.

|   |   |   |
|---|---|---|
| Age rating content descriptions  | Games  | Platform families  |
| Age ratings  | Game engines  | Platform logo's  |
| Alternative names  | Game engine logo's  | Platform version companies  |
| Artworks  | Game modes  | Platform versions  |
| Characters  | Game versions  | Platform version release dates  |
| Character mug shots  | Game version features  | Platform websites  |
| Collections  | Game version feature values  | Player perspectives  |
| Companies  | Game video's  | Screenshots  |
| Company logo's  | Genres  | Search  |
| Company websites  | Involved companies  | Themes  |
| Covers  | Keywords  | Websites  |
| External games  | Multiplayer modes  |   
| Franchises  | Platforms  |   

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
$igdb->game()->query('fields name, storyline, platforms.*; where platforms = (7, 9); sort id asc; limit 50'); //Using a custom query (see the Advanced Query builder section for creating queries programmatically)

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

*Note: Only the game, platform, collection, character and theme endpoints supports the `search()` method.*

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
    ->where('genre', 25)->where('platforms', 5)
    ->build();

//fields name; where platforms >= 5 & platforms <= 10;
$query = (new Query())
    ->fields('name')
    ->where('platforms', 5, '>=')->where('platforms', 10, '<=')
    ->build();
    
//fields name; where genre = 25 | platforms = (5, 7, 9);
$query = (new Query())
    ->fields('name')
    ->where('genre', 25)->orWhere('platforms', [5, 7, 9])
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
$ phpunit
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