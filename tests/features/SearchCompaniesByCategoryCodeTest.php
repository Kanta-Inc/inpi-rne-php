<?php

namespace InpiRNEClient;

use Mockery;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class SearchCompaniesByCategoryCodeTest extends MockeryTestCase
{
    private InpiRNEClientInterface $inpiRNEClient;

    protected function setUp(): void
    {
        $this->inpiRNEClient = new InpiRNEClient();
    }

    public function testSearchCompaniesByCategoryCode(): void
    {
        // get from file
        $fakeResponse = file_get_contents(__DIR__ . '/../fixtures/searchCompaniesByCategoryCode.json');

        $mockHandler = new MockHandler([new Response(200, [], $fakeResponse)]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->inpiRNEClient = new InpiRNEClient('fake_token', $mockedClient);

        // Testez le comportement de recherche
        $result = $this->inpiRNEClient->searchCompaniesByCategoryCode('01010101');
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

        $this->inpiRNEClient = new InpiRNEClient('fake_token', $mockedClient);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid input category code, please use a 8 length number.');

        $this->inpiRNEClient->searchCompaniesByCategoryCode('145d');
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
