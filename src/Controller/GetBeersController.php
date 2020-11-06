<?php

declare(strict_types=1);

namespace App\Controller;

use App\Api\ApiClientInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetBeersController 
{
    private $client;

    public function __construct(ApiClientInterface $client)
    {
        $this->client = $client;
    }

    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse(
            $this->client->beers(
                $request->get('food')
            )
        );
    }
}
