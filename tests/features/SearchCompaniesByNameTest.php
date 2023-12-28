<?php

namespace InpiRNEClient;

use Mockery;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class SearchCompaniesByNameTest extends MockeryTestCase
{
    private InpiRNEClientInterface $inpiRNEClient;

    protected function setUp(): void
    {
        $this->inpiRNEClient = new InpiRNEClient();
    }

    public function testSearchCompaniesByName(): void
    {
        // get from file
        $fakeResponse = file_get_contents(__DIR__ . '/../fixtures/searchCompaniesByName.json');

        $mockHandler = new MockHandler([new Response(200, [], $fakeResponse)]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->inpiRNEClient = new InpiRNEClient('fake_token', $mockedClient);

        // Testez le comportement de recherche
        $result = $this->inpiRNEClient->searchCompaniesByName('Kanta');
        $this->assertIsArray($result);

        $this->assertCount(20, $result['results']);

        $this->assertEquals(20, $result['resultsCount']);
        $this->assertTrue($result['hasMoreResults']);

        $this->assertEquals('895201283', $result['results'][0]['siren']);
        $this->assertEquals('63ae15152336741e76140cfb', $result['results'][0]['id']);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
