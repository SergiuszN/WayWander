<?php

namespace App\Tests\Unit\Infrastructure;

use App\Domain\World;
use App\Infrastructure\HttpMledozeWorldRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class HttpMledozeWorldRepositoryTest extends TestCase
{
    public function testLoad()
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')
            ->willReturn(json_decode('[{"name": {"official": "Czech Republic"},"cca3": "CZE","borders": ["AUT","BEL","CZE","DNK","FRA","LUX","NLD","POL","CHE"]},{"name": {"official": "Republic of Poland"},"cca3": "POL","borders": ["BLR","CZE","DEU","LTU","RUS","SVK","UKR"]}]', true));
        $response->method('getStatusCode')
            ->willReturn(200);

        $client = $this->createMock(HttpClientInterface::class);
        $client->method('request')
            ->willReturn($response);

        $repository = new HttpMledozeWorldRepository($client);
        $world = $repository->load();

        self::assertInstanceOf(World::class, $world);

        self::assertEquals('Czech Republic', $world->getCountry('CZE')->name);
        self::assertIsArray($world->getCountry('CZE')->borders);
        self::assertNotEmpty($world->getCountry('CZE')->borders);

        self::assertEquals('Republic of Poland', $world->getCountry('POL')->name);
        self::assertIsArray($world->getCountry('POL')->borders);
        self::assertNotEmpty($world->getCountry('POL')->borders);

        self::assertNull($world->getCountry('XX'));
    }

    public function testLoadingError()
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')
            ->willReturn(json_decode('[]', true));
        $response->method('getStatusCode')
            ->willReturn(500);

        $client = $this->createMock(HttpClientInterface::class);
        $client->method('request')
            ->willReturn($response);

        $repository = new HttpMledozeWorldRepository($client);
        $this->expectExceptionMessage('Can\'t download world from mledoze/countries.json!');
        $repository->load();
    }
}