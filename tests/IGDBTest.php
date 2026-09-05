<?php
declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Client;
use KrisKuiper\IGDBV4\Authentication\ValueObjects\AccessConfig;
use KrisKuiper\IGDBV4\Contracts\EndpointInterface;
use KrisKuiper\IGDBV4\Endpoints\AbstractEndpoint;
use KrisKuiper\IGDBV4\IGDB;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;

class IGDBTest extends TestCase
{
    /**
     * Guards the wiring: an endpoint that is not reachable through the facade cannot be used at all.
     */
    public function testShouldExposeEveryEndpointThroughTheFacade(): void
    {
        $this->assertSame([], array_diff($this->getEndpointClasses(), $this->getExposedEndpointClasses()));
    }

    public function testShouldExposeEveryEndpointOnlyOnce(): void
    {
        $exposed = $this->getExposedEndpointClasses();
        $this->assertSame(array_values(array_unique($exposed)), $exposed);
    }

    public function testShouldReturnEndpointsWithAUniqueUrlWhenAskingEveryEndpointName(): void
    {
        $urls = array_map(static fn (EndpointInterface $endpoint): string => $endpoint->getEndpoint(), $this->getEndpoints());

        $this->assertNotEmpty($urls);
        $this->assertSame(array_values(array_unique($urls)), $urls);
    }

    /**
     * Returns every concrete endpoint living in the package.
     *
     * @return string[]
     */
    private function getEndpointClasses(): array
    {
        $classes = [];

        foreach (glob(__DIR__ . '/../src/Endpoints/*Endpoint.php') ?: [] as $file) {
            $class = 'KrisKuiper\\IGDBV4\\Endpoints\\' . basename($file, '.php');

            if (false === (new ReflectionClass($class))->isAbstract()) {
                $classes[] = $class;
            }
        }

        sort($classes);

        return $classes;
    }

    /**
     * Returns the endpoint behind every accessor of the facade.
     *
     * @return string[]
     */
    private function getExposedEndpointClasses(): array
    {
        $classes = array_map(static fn (EndpointInterface $endpoint): string => $endpoint::class, $this->getEndpoints());
        sort($classes);

        return $classes;
    }

    /**
     * @return EndpointInterface[]
     */
    private function getEndpoints(): array
    {
        $igdb = new IGDB(new Client(), new AccessConfig('clientId', 'accessToken'));
        $endpoints = [];

        foreach ((new ReflectionClass(IGDB::class))->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if (true === $method->isConstructor() || 0 !== $method->getNumberOfParameters()) {
                continue;
            }

            $endpoint = $method->invoke($igdb);

            if ($endpoint instanceof AbstractEndpoint) {
                $endpoints[] = $endpoint;
            }
        }

        return $endpoints;
    }
}
