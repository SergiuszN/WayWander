<?php

namespace App\Tests\Unit\Domain;

use App\Domain\Country;
use App\Domain\Router\RouterInterface;
use App\Domain\World;
use App\Domain\WorldNavigator;
use App\Domain\WorldRepositoryInterface;
use PHPUnit\Framework\TestCase;

class WorldNavigatorTest extends TestCase
{
    public function testNavigate()
    {
        $worldRepository = $this->createMock(WorldRepositoryInterface::class);
        $worldRepository->method('load')
            ->willReturn(new World([
                new Country('CZ', 'CZ', []),
                new Country('PL', 'PL', []),
            ]));

        $router = $this->createMock(RouterInterface::class);
        $router->method('find')
            ->willReturn(['x']);

        $worldNavigator = new WorldNavigator($worldRepository, $router);

        self::assertNull($worldNavigator->navigate('XX', 'CZ'));
        self::assertNull($worldNavigator->navigate('PL', 'XX'));
        self::assertEquals(['x'], $worldNavigator->navigate('PL', 'CZ'));
    }
}