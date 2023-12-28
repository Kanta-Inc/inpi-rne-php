<?php

namespace RNEClient;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class SearchCompanyOldStateBySirenTest extends TestCase
{
    private RNEClientInterface $RNEClient;

    protected function setUp(): void
    {
        $this->RNEClient = new RNEClient();
    }

    public function testSearchCompanyOldStateBySiren(): void
    {
        // get from file
        $fakeResponse = file_get_contents(__DIR__ . '/../fixtures/searchCompanyOldStateBySiren.json');

        $mockHandler = new MockHandler([new Response(200, [], $fakeResponse)]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->RNEClient = new RNEClient('fake_token', $mockedClient);

        // Testez le comportement de recherche
        $result = $this->RNEClient->searchCompanyOldStateBySiren('889924320', '2021-01-01');
        $this->assertIsArray($result);
        $this->assertEquals('889924320', $result['siren']);
        $this->assertEquals('63ade9a1e0e85a58e30d53cd', $result['id']);
        $this->assertEquals('LEMARIEY', $result['formality']['content']['personneMorale']['beneficiairesEffectifs'][0]['beneficiaire']['descriptionPersonne']['nom']);
        $this->assertEquals('Française', $result['formality']['content']['personneMorale']['beneficiairesEffectifs'][0]['beneficiaire']['descriptionPersonne']['nationalite']);
    }

    public function testSearchCompanyOldStateBySirenWithBadSiren(): void
    {
        $client = new RNEClient();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid input siren, please use a 9 length number.");
        $client->searchCompanyBySiren('bad_siren');
    }

    public function testSearchCompanyOldStateBySirenWithShortSiren(): void
    {
        $client = new RNEClient();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid input siren, please use a 9 length number.");
        $client->searchCompanyBySiren('12345678');
    }

    public function testSearchCompanyOldStateBySirenWithLongSiren(): void
    {
        $client = new RNEClient();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid input siren, please use a 9 length number.");
        $client->searchCompanyBySiren('1234567890');
    }

    public function testSearchCompanyOldStateBySirenWithBadDate(): void
    {
        $client = new RNEClient();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid input date, please use YYYY-MM-DD format.");
        $client->searchCompanyOldStateBySiren('889924320', 'bad_date');
    }
}
