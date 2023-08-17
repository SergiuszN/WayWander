<?php

namespace App\Domain;

use App\Domain\Router\RouterInterface;

class WorldNavigator
{
    private World $world;

    public function __construct(
        public readonly WorldRepositoryInterface $worldRepository,
        public readonly RouterInterface $router,
    ) {
        $this->world = $this->worldRepository->load();
        $this->router->setWorld($this->world);
    }

    public function navigate(string $origin, string $destination): ?array
    {
        $from = $this->world->getCountry($origin);
        $to = $this->world->getCountry($destination);

        if ($from === null || $to === null) {
            return null;
        }

        return $this->router->find($from, $to);
    }
}
