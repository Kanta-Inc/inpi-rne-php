<?php

namespace RNEClient;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class SearchCompanyBySirenTest extends TestCase
{
    private RNEClientInterface $RNEClient;

    protected function setUp(): void
    {
        $this->RNEClient = new RNEClient();
    }

    public function testSearchCompanyBySiren(): void
    {
        // get from file
        $fakeResponse = file_get_contents(__DIR__ . '/../fixtures/searchCompanyBySiren.json');

        $mockHandler = new MockHandler([new Response(200, [], $fakeResponse)]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->RNEClient = new RNEClient('fake_token', $mockedClient);

        // Testez le comportement de recherche
        $result = $this->RNEClient->searchCompanyBySiren('889924320');
        $this->assertIsArray($result);
        $this->assertEquals('889924320', $result['siren']);
        $this->assertEquals('63ade9a1e0e85a58e30d53cd', $result['id']);
        $this->assertEquals('LEPETIT', $result['formality']['content']['personneMorale']['beneficiairesEffectifs'][0]['beneficiaire']['descriptionPersonne']['nom']);
        $this->assertEquals('Française', $result['formality']['content']['personneMorale']['beneficiairesEffectifs'][0]['beneficiaire']['descriptionPersonne']['nationalite']);
    }

    public function testSearchCompanyBySirenWithApiError(): void
    {
        $mockHandler = new MockHandler([new Response(500, [], '[]')]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->RNEClient = new RNEClient('fake_token', $mockedClient);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Unknown error");
        $this->RNEClient->searchCompanyBySiren('889924320');
    }

    public function testSearchCompanyBySirenWithBadSiren(): void
    {
        $client = new RNEClient();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid input siren, please use a 9 length number.");
        $client->searchCompanyBySiren('bad_siren');
    }

    public function testSearchCompanyBySirenWithShortSiren(): void
    {
        $client = new RNEClient();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid input siren, please use a 9 length number.");
        $client->searchCompanyBySiren('12345678');
    }

    public function testSearchCompanyBySirenWithLongSiren(): void
    {
        $client = new RNEClient();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid input siren, please use a 9 length number.");
        $client->searchCompanyBySiren('1234567890');
    }
}
