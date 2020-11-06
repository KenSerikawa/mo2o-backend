<?php

namespace App\Api\Exception;

use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

final class BeerNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Beer not found', Response::HTTP_NOT_FOUND);
    }
}