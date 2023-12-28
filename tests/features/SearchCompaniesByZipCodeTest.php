<?php

namespace RNEClient;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class SearchCompaniesByZipCodeTest extends TestCase
{
    private RNEClientInterface $RNEClient;

    protected function setUp(): void
    {
        $this->RNEClient = new RNEClient();
    }

    public function testSearchCompaniesByZipCode(): void
    {
        // get from file
        $fakeResponse = file_get_contents(__DIR__ . '/../fixtures/searchCompaniesByZipCode.json');

        $mockHandler = new MockHandler([new Response(200, [], $fakeResponse)]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->RNEClient = new RNEClient('fake_token', $mockedClient);

        // Testez le comportement de recherche
        $result = $this->RNEClient->searchCompaniesByZipCode('75001');
        $this->assertIsArray($result);

        $this->assertCount(20, $result['results']);

        $this->assertEquals(20, $result['resultsCount']);
        $this->assertTrue($result['hasMoreResults']);
    }

    public function testSearchCompaniesByZipCodeWithBadZipCode(): void
    {
        $client = new RNEClient();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid input zip code, please use a 5 length number.");
        $client->searchCompaniesByZipCode('bad_zip_code');
    }

    public function testSearchCompaniesByZipCodeWithShortZipCode(): void
    {
        $client = new RNEClient();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid input zip code, please use a 5 length number.");
        $client->searchCompaniesByZipCode('1234');
    }

    public function testSearchCompaniesByZipCodeWithLongZipCode(): void
    {
        $client = new RNEClient();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid input zip code, please use a 5 length number.");
        $client->searchCompaniesByZipCode('123456');
    }
}
