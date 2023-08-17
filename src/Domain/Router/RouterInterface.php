<?php

namespace App\Domain\Router;

use App\Domain\Country;
use App\Domain\World;

interface RouterInterface
{
    public function setWorld(World $world);

    public function find(Country $from, Country $to): ?array;
}