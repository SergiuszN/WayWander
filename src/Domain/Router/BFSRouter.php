<?php

namespace App\Domain\Router;

use App\Domain\Country;
use App\Domain\World;

class BFSRouter implements RouterInterface
{
    private ?World $world;

    public function setWorld(World $world)
    {
        $this->world = $world;
    }

    public function find(Country $from, Country $to): ?array
    {
        [$visited, $parents] = [[], []];

        if ($from->key === $to->key) {
            return [$from->key];
        }

        $visited[$from->key] = true;
        $queue = [$from->key];
        $node = null;

        while (!empty($queue)) {
            $node = array_shift($queue);

            if ($node === $to->key) {
                break;
            }

            foreach ($this->world->getCountry($node)->borders as $neighbor) {
                if (!isset($visited[$neighbor])) {
                    $visited[$neighbor] = true;
                    $parents[$neighbor] = $node;
                    $queue[] = $neighbor;
                }
            }
        }

        if ($node !== $to->key) {
            return null;
        }

        $road = [];

        while ($node) {
            if (!isset($parents[$node])) {
                break;
            }

            $step = $parents[$node];
            $road[] = $step;
            $node = $step;
        }

        $road = array_reverse($road);
        $road[] = $to->key;

        return $road;
    }
}
