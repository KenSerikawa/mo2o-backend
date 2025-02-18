<?php

namespace App\Tests\Api;

use GuzzleHttp\Client;
use App\Api\ApiClient;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\ClientException;
use App\Api\Exception\BeerNotFoundException;
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

    /** @test */
    public function shouldGetBeerDetails()
    {
        $clientMock = $this->createMock(Client::class);
        $id = 1;
        $beerTested =  [
            [
            'id' => $id,
            'name' => 'beer',
            'description' => 'this is a description',
            'image_url' => 'image_path',
            'tagline' => 'This is a slogan',
            'first_brewed' => '01/2020',
            ]
        ];

        $response = new Response(200, [], json_encode($beerTested));
        
        $clientMock->expects($this->once())
            ->method('get')
            ->with("beers/{$id}", [])
            ->willReturn($response);

        /** @var ClientInterface $clientMock */  
        $apiClient = new ApiClient($clientMock);

        $beers = $apiClient->beerDetails($id);

        foreach ($beers as $beer) {
            $this->assertArrayHasKey('id', $beer);
            $this->assertNotNull($beer['id']);
            $this->assertArrayHasKey('name', $beer);
            $this->assertNotNull($beer['name']);
            $this->assertArrayHasKey('description', $beer);
            $this->assertNotNull($beer['description']);
            $this->assertArrayHasKey('tagline', $beer);
            $this->assertNotNull($beer['tagline']);
            $this->assertArrayHasKey('image_url', $beer);
            $this->assertNotNull($beer['image_url']);
            $this->assertArrayHasKey('first_brewed', $beer);
            $this->assertNotNull($beer['first_brewed']);
            $this->assertCount(6, $beer);
        }
    }

    /** @test */
    public function shouldThrowExceptionWhenBeerNotFound()
    {
        $this->expectException(BeerNotFoundException::class);
        $id = 987113;
        $clientMock = $this->createMock(Client::class);
        
        /** @var RequestInterface $requestMock */ 
        $requestMock = $this->createMock(RequestInterface::class);
        
        /** @var ResponseInterface $responseMock */ 
        $responseMock = $this->createMock(ResponseInterface::class);
        $exception = new ClientException(
            'Beer not found',
            $requestMock,
            $responseMock
        );

        $clientMock->expects($this->once())
            ->method('get')
            ->with("beers/{$id}", [])
            ->willThrowException($exception);

        /** @var ClientInterface $clientMock */  
        $apiClient = new ApiClient($clientMock);

        $apiClient->beerDetails($id);
    }
}
