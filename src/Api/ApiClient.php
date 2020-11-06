<?php

declare(strict_types=1);

namespace App\Api;

use GuzzleHttp\Client;
use App\Api\ApiClientInterface;
use GuzzleHttp\ClientInterface;

final class ApiClient implements ApiClientInterface
{
    /** @var Client */
    private $client; 

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function beers(string $query)
    {
        $res = $this->client->get("beers", $this->prepareQueryParameters($query));

        $beers = json_decode($res->getBody()->getContents(), true);
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
}