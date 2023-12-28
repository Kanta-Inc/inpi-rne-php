<?php

namespace InpiRNEClient;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class SearchCompaniesByActivitySectorTest extends TestCase
{
    private InpiRNEClientInterface $inpiRNEClient;

    protected function setUp(): void
    {
        $this->inpiRNEClient = new InpiRNEClient();
    }

    public function testSearchCompaniesByActivitySector(): void
    {
        // get from file
        $fakeResponse = file_get_contents(__DIR__ . '/../fixtures/searchCompaniesByActivitySector.json');

        $mockHandler = new MockHandler([new Response(200, [], $fakeResponse)]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->inpiRNEClient = new InpiRNEClient('fake_token', $mockedClient);

        // Testez le comportement de recherche
        $result = $this->inpiRNEClient->searchCompaniesByActivitySector('AGENT_COMMERCIAL');
        $this->assertIsArray($result);

        // count($result) = 2
        $this->assertCount(20, $result['results']);

        // assert decorations resultsCount == 2
        // assert decorations hasMoreResults == false
        $this->assertEquals(20, $result['resultsCount']);
        $this->assertTrue($result['hasMoreResults']);

        $this->assertEquals('330068131', $result['results'][0]['siren']);
        $this->assertEquals('63a6db39f3a712189f0540e9', $result['results'][0]['id']);
        // formeExerciceActivitePrincipale
        $this->assertEquals('AGENT_COMMERCIAL', $result['results'][0]['formality']['content']['formeExerciceActivitePrincipale']);
    }

    public function testSearchCompaniesByActivitySectorWithBadActivitySector(): void
    {
        $mockHandler = new MockHandler([new Response(200, [], '[]')]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->inpiRNEClient = new InpiRNEClient('fake_token', $mockedClient);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid input activity sector, please use one of the following values: ' . implode(', ', $this->inpiRNEClient::VALID_ACTIVITY_SECTORS) . '.');

        // Testez le comportement de recherche
        $this->inpiRNEClient->searchCompaniesByActivitySector('BAD_ACTIVITY_SECTOR');
    }
}
