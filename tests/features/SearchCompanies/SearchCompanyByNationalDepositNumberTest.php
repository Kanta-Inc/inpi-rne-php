<?php

namespace RNEClient;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class SearchCompanyByNationalDepositNumberTest extends TestCase
{
    private SearchCompaniesInterface $RNEClient;

    protected function setUp(): void
    {
        $this->RNEClient = new SearchCompanies();
    }

    public function testSearchCompanyByNationalDepositNumber(): void
    {
        // get from file
        $fakeResponse = file_get_contents(__DIR__ . '/../../fixtures/SearchCompanies/searchByNationalDepositNumber.json');

        $mockHandler = new MockHandler([new Response(200, [], $fakeResponse)]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->RNEClient = new SearchCompanies('fake_token', $mockedClient);

        // Testez le comportement de recherche
        $result = $this->RNEClient->searchByNationalDepositNumber('23548795564');
        $this->assertIsArray($result);
        $this->assertEquals('889924320', $result['siren']);
        $this->assertEquals('63ade9a1e0e85a58e30d53cd', $result['id']);
        $this->assertEquals('LEPETIT', $result['formality']['content']['personneMorale']['beneficiairesEffectifs'][0]['beneficiaire']['descriptionPersonne']['nom']);
        $this->assertEquals('Française', $result['formality']['content']['personneMorale']['beneficiairesEffectifs'][0]['beneficiaire']['descriptionPersonne']['nationalite']);
    }

    public function testSearchCompanyByNationalDepositNumberWithBadSiren(): void
    {
        $client = new SearchCompanies();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid input siren, please use a 9 length number.");
        $client->searchBySiren('bad_siren');
    }

    public function testSearchCompanyByNationalDepositNumberWithShortSiren(): void
    {
        $client = new SearchCompanies();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid input siren, please use a 9 length number.");
        $client->searchBySiren('12345678');
    }

    public function testSearchCompanyByNationalDepositNumberWithLongSiren(): void
    {
        $client = new SearchCompanies();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid input siren, please use a 9 length number.");
        $client->searchBySiren('1234567890');
    }
}
