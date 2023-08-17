<?php

namespace App\Tests\Unit\Domain\Router;

use App\Domain\Country;
use App\Domain\Router\BFSRouter;
use App\Domain\World;
use PHPUnit\Framework\TestCase;

class BFSRouterTest extends TestCase
{
    private World $world;

    public function setUp(): void
    {
        parent::setUp();
        $this->world = new World([
            new Country('PT', 'PT', ['ES']),
            new Country('ES', 'ES', ['PT', 'FR']),
            new Country('FR', 'FR', ['ES', 'DE']),
            new Country('DE', 'DE', ['CZ', 'PL', 'FR']),
            new Country('CZ', 'CZ', ['PL', 'DE']),
            new Country('PL', 'PL', ['CZ', 'DE']),
            new Country('UK', 'UK', []),
        ]);
    }

    /**
     * @dataProvider findDataProvider
     */
    public function testFind(Country $from, Country $to, ?array $expectedRoute): void
    {
        $bfsRouter = new BFSRouter();
        $bfsRouter->setWorld($this->world);
        self::assertEquals($expectedRoute, $bfsRouter->find($from, $to));
    }

    public function findDataProvider(): array
    {
        return [
            '1 country test' => [new Country('PL', 'x', []), new Country('FR', 'x', []), ['PL', 'DE', 'FR']],
            '3 country test' => [new Country('PT', 'x', []), new Country('CZ', 'x', []), ['PT', 'ES', 'FR', 'DE', 'CZ']],
            'border test' => [new Country('PL', 'x', []), new Country('CZ', 'x', []), ['PL', 'CZ']],
            'same country test' => [new Country('PL', 'x', []), new Country('PL', 'x', []), ['PL']],
            'no path test' => [new Country('UK', 'x', []), new Country('CZ', 'x', []), null],
            'no path reverse test' => [new Country('CZ', 'x', []), new Country('UK', 'x', []), null],
        ];
    }
}