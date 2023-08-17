<?php

namespace App\Application\Http\Controller;

use App\Domain\WorldNavigator;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/routing')]
class RoutingController
{
    public function __construct(
        public readonly WorldNavigator $worldNavigator
    ) {
    }

    #[Route('/{origin}/{destination}', name: 'routing_navigate')]
    public function navigate(string $origin, string $destination): JsonResponse
    {
        $route = $this->worldNavigator->navigate($origin, $destination);

        if (!$route) {
            throw new BadRequestException();
        }

        return new JsonResponse([
            'route' => $route,
        ]);
    }
}
