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

    }
}