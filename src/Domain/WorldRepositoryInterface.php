<?php

namespace App\Domain;

interface WorldRepositoryInterface
{
    public function load(): World;
}