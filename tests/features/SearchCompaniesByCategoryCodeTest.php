<?php

namespace RNEClient;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class SearchCompaniesByCategoryCodeTest extends TestCase
{
    private RNEClientInterface $RNEClient;

    protected function setUp(): void
    {
        $this->RNEClient = new RNEClient();
    }

    public function testSearchCompaniesByCategoryCode(): void
    {
        // get from file
        $fakeResponse = file_get_contents(__DIR__ . '/../fixtures/searchCompaniesByCategoryCode.json');

        $mockHandler = new MockHandler([new Response(200, [], $fakeResponse)]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->RNEClient = new RNEClient('fake_token', $mockedClient);

        // Testez le comportement de recherche
        $result = $this->RNEClient->searchCompaniesByCategoryCode('01010101');
        $this->assertIsArray($result);

        $this->assertCount(20, $result['results']);

        $this->assertEquals(20, $result['resultsCount']);
        $this->assertTrue($result['hasMoreResults']);

        // formeExerciceActivitePrincipale
        $this->assertEquals('COMMERCIALE', $result['results'][0]['formality']['content']['formeExerciceActivitePrincipale']);
    }

    public function testSearchCompaniesByCategoryCodeWithBadCategoryCode(): void
    {
        $mockHandler = new MockHandler([new Response(200, [], '[]')]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->RNEClient = new RNEClient('fake_token', $mockedClient);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid input category code, please use a 8 length number.');

        $this->RNEClient->searchCompaniesByCategoryCode('145d');
    }
}
