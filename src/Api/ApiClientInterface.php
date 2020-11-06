<?php

declare(strict_types=1);

namespace App\Api;

interface ApiClientInterface
{
    public function beers(?string $query);
    
    public function beerDetails(string $id);
}