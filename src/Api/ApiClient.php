<?php

declare(strict_types=1);

namespace App\Api;

use GuzzleHttp\Client;
use App\Api\ApiClientInterface;
use GuzzleHttp\ClientInterface;

use function Lambdish\Phunctional\get;
use function Lambdish\Phunctional\map;

final class ApiClient implements ApiClientInterface
{
    /** @var Client */
    private $client; 

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function beers(?string $query)
    {
        $res = $this->client->get("beers", $this->prepareQueryParameters($query));

        $beers = json_decode($res->getBody()->getContents(), true);

        return $this->parseBeersResponse($beers);
    }

    private function prepareQueryParameters(?string $query)
    {
        if (null !== $query) {
            return [
                'query' => [
                    'food' => $query
                ]
            ];
        }

        return [];
    }

    private function parseBeersResponse(array $beers)
    {
        return map(function($beer) {
            return $this->extractCommonBeerProperties($beer);
        }, $beers);
    }

    private function extractCommonBeerProperties(array $beer)
    {
        return [
            'id'          => get('id', $beer),
            'name'        => get('name', $beer),
            'description' => get('description', $beer)
        ];
    }
}
