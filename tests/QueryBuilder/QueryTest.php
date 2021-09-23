<?php
declare(strict_types=1);

namespace Tests\QueryBuilder;

use KrisKuiper\IGDBV4\QueryBuilder\Query;
use PHPUnit\Framework\TestCase;

class QueryTest extends TestCase
{
    private Query $query;

    public function setup(): void
    {
        $this->query = new Query();
        parent::setup();
    }

    public function testShouldReturnCorrectQueryWhenSelectingFields(): void
    {
        $query = $this->query->fields('id', 'name', 'genre.name')->build();
        $this->assertEquals('fields id, name, genre.name;', $query);
    }

    public function testShouldReturnCorrectQueryWhenUsingSearch(): void
    {
        $query = $this->query->search('Metal Gear Solid')->build();
        $this->assertEquals('search "Metal Gear Solid";', $query);

        $query = $this->query->search('Metal G"ear Solid')->build();
        $this->assertEquals('search "Metal G\"ear Solid";', $query);
    }

    public function testShouldReturnCorrectQueryWhenUsingSort(): void
    {
        $query = $this->query->sort('id')->build();
        $this->assertEquals('sort id asc;', $query);

        $query = $this->query->sort('id', 'asc')->build();
        $this->assertEquals('sort id asc;', $query);

        $query = $this->query->sort('id', 'desc')->build();
        $this->assertEquals('sort id desc;', $query);
    }

    public function testShouldReturnCorrectQueryWhenUsingLimit(): void
    {
        $query = $this->query->limit(10)->build();
        $this->assertEquals('limit 10;', $query);
    }

    public function testShouldReturnCorrectQueryWhenUsingOffset(): void
    {
        $query = $this->query->offset(10)->build();
        $this->assertEquals('offset 10;', $query);
    }

    public function testShouldReturnCorrectQueryWhenUsingExclude(): void
    {
        $query = $this->query->exclude('id', 'name', 'genre.name')->build();
        $this->assertEquals('exclude id, name, genre.name;', $query);
    }

    public function testShouldReturnCorrectQueryWhenUsingWhere(): void
    {
        $query = $this->query->where('id', 1)->build();
        $this->assertEquals('where id = 1;', $query);
    }

    public function testShouldReturnCorrectQueryWhenUsingWhereWithOperator(): void
    {
        $query = $this->query->where('id', 1, '!=')->build();
        $this->assertEquals('where id != 1;', $query);
    }

    public function testShouldReturnCorrectQueryWhenUsingWhereIn(): void
    {
        $query = $this->query->where('id', [1, 2, 3])->build();
        $this->assertEquals('where id = (1, 2, 3);', $query);
    }

    public function testShouldReturnCorrectQueryWhenUsingWhereInWithOperator(): void
    {
        $query = $this->query->where('id', [1, 2, 3], '!=')->build();
        $this->assertEquals('where id != (1, 2, 3);', $query);
    }

    public function testShouldReturnCorrectQueryWhenUsingGroupWhere(): void
    {
        $query = $this->query->where(static function($query) {
            $query->where('id', 1);
        })->build();

        $this->assertEquals('where (id = 1);', $query);
    }

    public function testShouldReturnCorrectQueryWhenUsingAdvancedGroupWhere(): void
    {
        $query = $this->query
            ->where(static function($query) {
                $query->where('id', 1)
                    ->orWhere('id', 2);
            })
            ->where(static function($query) {
                $query->where('id', 3)
                    ->orWhere('id', 4);
            })
            ->orWhere(static function($query) {
                $query->where('id', 5)
                    ->orWhere(static function($query) {
                        $query->where('id', 6)
                            ->where('id', 7)
                            ->orWhere('id', 8);
                    });
            })
            ->build();

        $this->assertEquals('where (id = 1 | id = 2) & (id = 3 | id = 4) | (id = 5 | (id = 6 & id = 7 | id = 8));', $query);
    }

    public function testShouldReturnCorrectQueryWhenUsingGroupWhereWithOperator(): void
    {
        $query = $this->query->where(static function($query) {
            $query->where('id', 1, '!=');
        })->build();

        $this->assertEquals('where (id != 1);', $query);
    }

    public function testShouldReturnCorrectQueryWhenChainingTypes(): void
    {
        $query = $this->query
            ->fields('*')
            ->sort('name')
            ->limit(5)
            ->offset(2)
            ->search('Metal Gear Solid')
            ->exclude('genre')
            ->where('id', 1)
            ->orWhere('genres', [1, 2, 3])
            ->build();

        $this->assertEquals('fields *; exclude genre; search "Metal Gear Solid"; where id = 1 | genres = (1, 2, 3); sort name asc; offset 2; limit 5;', $query);
    }
}