<?php

namespace RNEClient;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class DifferentialSearchByMultipleSirenTest extends TestCase
{
    private DifferentialSearchInterface $RNEClient;

    protected function setUp(): void
    {
        $this->RNEClient = new DifferentialSearch('fake_token');
    }

    public function testDifferentialSearchByMultipleSiren(): void
    {
        // get from file
        $fakeResponse = file_get_contents(__DIR__ . '/../../fixtures/differentialSearchByMultipleSiren.json');

        $mockHandler = new MockHandler([new Response(200, [], $fakeResponse)]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->RNEClient = new DifferentialSearch('fake_token', $mockedClient);

        // Testez le comportement de recherche
        $result = $this->RNEClient->searchByMultipleSiren(['889924320', '894419969'], '2021-01-01', '2023-01-31');
        $this->assertIsArray($result);

        // count($result) = 2
        $this->assertCount(2, $result['results']);

        // assert decorations resultsCount == 2
        // assert decorations hasMoreResults == false
        $this->assertEquals(2, $result['resultsCount']);
        $this->assertFalse($result['hasMoreResults']);

        $this->assertEquals('894419969', $result['results'][0]['company']['formality']['siren']);
        $this->assertEquals('63ae0d5d49fa7d125811404b', $result['results'][0]['company']['id']);

        $this->assertEquals('889924320', $result['results'][1]['company']['formality']['siren']);
        $this->assertEquals('63ade9a1e0e85a58e30d53cd', $result['results'][1]['company']['id']);
    }
}
