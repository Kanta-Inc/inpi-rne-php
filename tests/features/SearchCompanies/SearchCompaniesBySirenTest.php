<?php

namespace RNEClient;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class SearchCompaniesBySirenTest extends TestCase
{
    private SearchCompaniesInterface $RNEClient;

    protected function setUp(): void
    {
        $this->RNEClient = new SearchCompanies('fake_token');
    }

    public function testSearchCompaniesBySiren(): void
    {
        // get from file
        $fakeResponse = file_get_contents(__DIR__ . '/../../fixtures/SearchCompanies/searchByMultipleSiren.json');

        $mockHandler = new MockHandler([new Response(200, [], $fakeResponse)]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->RNEClient = new SearchCompanies('fake_token', $mockedClient);

        // Testez le comportement de recherche
        $result = $this->RNEClient->searchByMultipleSiren(['889924320', '894419969']);
        $this->assertIsArray($result);

        // count($result) = 2
        $this->assertCount(2, $result['results']);

        // assert decorations resultsCount == 2
        // assert decorations hasMoreResults == false
        $this->assertEquals(2, $result['resultsCount']);
        $this->assertFalse($result['hasMoreResults']);

        $this->assertEquals('889924320', $result['results'][0]['siren']);
        $this->assertEquals('63ade9a1e0e85a58e30d53cd', $result['results'][0]['id']);
        $this->assertEquals('LEPETIT', $result['results'][0]['formality']['content']['personneMorale']['beneficiairesEffectifs'][0]['beneficiaire']['descriptionPersonne']['nom']);
        $this->assertEquals('Française', $result['results'][0]['formality']['content']['personneMorale']['beneficiairesEffectifs'][0]['beneficiaire']['descriptionPersonne']['nationalite']);

        $this->assertEquals('894419969', $result['results'][1]['siren']);
        $this->assertEquals('63ae0d5d49fa7d125811404b', $result['results'][1]['id']);
        $this->assertEquals('GUILLOUF', $result['results'][1]['formality']['content']['personneMorale']['beneficiairesEffectifs'][0]['beneficiaire']['descriptionPersonne']['nom']);
        $this->assertEquals('Française', $result['results'][1]['formality']['content']['personneMorale']['beneficiairesEffectifs'][0]['beneficiaire']['descriptionPersonne']['nationalite']);
    }

    public function testSearchCompaniesBySirenWithBadSirenFormat(): void
    {
        $mockHandler = new MockHandler([new Response(200, [], '[]')]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->RNEClient = new SearchCompanies('fake_token', $mockedClient);

        // Testez que l'exception est bien levée lors de l'authentification avec de mauvais identifiants
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid input siren, please use a 9 length number.");

        $this->RNEClient->searchByMultipleSiren(['x', '8899243dd20']);
    }

    public function testSearchCompaniesBySirenWithBadPageSize(): void
    {
        $mockHandler = new MockHandler([new Response(200, [], '[]')]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->RNEClient = new SearchCompanies('fake_token', $mockedClient);

        // Testez que l'exception est bien levée lors de l'authentification avec de mauvais identifiants
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid input page size, please use a number between 1 and 100.");

        $this->RNEClient->searchByMultipleSiren(['889924320', '894419969'], 0);
    }

    public function testSearchCompaniesBySirenWithBadPageNumber(): void
    {
        $mockHandler = new MockHandler([new Response(200, [], '[]')]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->RNEClient = new SearchCompanies('fake_token', $mockedClient);

        // Testez que l'exception est bien levée lors de l'authentification avec de mauvais identifiants
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid input page, please use a number greater than 0.");

        $this->RNEClient->searchByMultipleSiren(['889924320', '894419969'], 10, 0);
    }
}
