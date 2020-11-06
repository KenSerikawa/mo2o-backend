<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetBeersController 
{
    private $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function __invoke(Request $request)
    {
        
    }
} 