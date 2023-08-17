<?php

namespace App\Domain;

class World
{
    private array $countries = [];

    /**
     * @param array|Country[] $countries
     */
    public function __construct(array $countries)
    {
        foreach ($countries as $country) {
            $this->countries[$country->key] = $country;
        }
    }

    public function getCountry(string $key): ?Country
    {
        return $this->countries[$key] ?? null;
    }
}