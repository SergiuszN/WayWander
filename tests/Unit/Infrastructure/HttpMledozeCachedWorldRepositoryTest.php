<?php

namespace App\Tests\Unit\Infrastructure;

use App\Infrastructure\HttpMledozeCachedWorldRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class HttpMledozeCachedWorldRepositoryTest extends TestCase
{
    public function testLoad()
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')
            ->willReturn(json_decode('[]', true));
        $response->method('getStatusCode')
            ->willReturn(200);

        $client = $this->createMock(HttpClientInterface::class);
        $client->method('request')
            ->willReturn($response);

        $adapter = new ArrayAdapter();
        $repository = new HttpMledozeCachedWorldRepository($client, $adapter);
        $firstWorld = $repository->load();
        $secondWorld = $repository->load();

        self::assertEquals($firstWorld, $secondWorld);
        self::assertEquals($firstWorld, $adapter->getItem('mledoze_country_list_cache')->get());
    }
}