<?php

namespace App\Domain;

readonly class Country
{
    public function __construct(
        public string $key,
        public string $name,
        public array $borders,
    ) {
    }
}
