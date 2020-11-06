<?php

namespace App\Tests\Api;

use App\Api\ApiClient;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ApiClientTest extends WebTestCase
{
    /** @test */
    public function shouldGetAllBeers()
    {
        $clientMock = $this->createMock(Client::class);

        $response = new Response(200, [], json_encode([
            [
                'id' => 1,
                'name' => 'beer',
                'description' => 'this is a description'
            ]
        ]));

        $clientMock->expects($this->once())
                ->method('get')
                ->with('beers', [])
                ->willReturn($response);

        $apiClient = new ApiClient($clientMock);

        $beers = $apiClient->beers(null);

        foreach ($beers as $beer) {
            $this->assertArrayHasKey('id', $beer);
            $this->assertNotNull($beer['id']);
            $this->assertArrayHasKey('name', $beer);
            $this->assertNotNull($beer['name']);
            $this->assertArrayHasKey('description', $beer);
            $this->assertNotNull($beer['description']);

            $this->assertCount(3, $beer);
        }
    }
}
