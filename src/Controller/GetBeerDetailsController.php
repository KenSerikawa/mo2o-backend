<?php

declare(strict_types=1);

namespace App\Controller;

use App\Api\ApiClientInterface;
use App\Api\Exception\BeerNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetBeerDetailsController
{
    private $client;

    public function __construct(ApiClientInterface $client)
    {
        $this->client = $client;
    }
    
    public function __invoke(string $id): JsonResponse
    {   
        try {
            return new JsonResponse(
                $this->client->beerDetails($id)
            );
        } catch (BeerNotFoundException $e) {
            return new JsonResponse(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
