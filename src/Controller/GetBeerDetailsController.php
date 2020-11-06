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
        $response = new JsonResponse();
        try {
            $response->setData($this->client->beerDetails($id));
        } catch (BeerNotFoundException $e) {
            $response->setData(['message' => $e->getMessage()])
                     ->setStatusCode($e->getCode());
        } finally {
            return $response;
        }
    }
}
