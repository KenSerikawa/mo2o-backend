<?php

declare(strict_types=1);

namespace App\Api;

use GuzzleHttp\Client;

final class ApiClient 
{
    /** @var Client */
    private $client; 

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function beers(string $query)
    {
    
    }
}