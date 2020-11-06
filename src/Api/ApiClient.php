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

    public function beerDetails(string $id)
    {
        $res = $this->client->get("beers/{$id}");
       
        $beer = json_decode($res->getBody()->getContents(), true);

        return $this->parseBeerDetailsResponse($beer);
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

    private function parseBeerDetailsResponse(array $beers)
    {
        return map(function($beer) {
            return $this->extractBeerDetails($beer);
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

    private function extractBeerDetails(array $beer)
    {
        return array_merge(
            $this->extractCommonBeerProperties($beer),
            [
                'tagline'        => get('tagline', $beer),
                'image_url'      => get('image_url', $beer),
                'first_brewed'   => get('first_brewed', $beer),
            ]
        );
    }
}
