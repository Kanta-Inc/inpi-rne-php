<?php

namespace InpiRNEClient;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class SearchCompaniesBySubmissionDateTest extends TestCase
{
    private InpiRNEClientInterface $inpiRNEClient;

    protected function setUp(): void
    {
        $this->inpiRNEClient = new InpiRNEClient();
    }

    public function testSearchCompaniesBySubmissionDate(): void
    {
        // get from file
        $fakeResponse = file_get_contents(__DIR__ . '/../fixtures/searchCompaniesBySubmissionDate.json');

        $mockHandler = new MockHandler([new Response(200, [], $fakeResponse)]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->inpiRNEClient = new InpiRNEClient('fake_token', $mockedClient);

        // Testez le comportement de recherche
        $result = $this->inpiRNEClient->searchCompaniesBySubmissionDate('2022-04-01', '2022-04-02');
        $this->assertIsArray($result);

        $this->assertCount(20, $result['results']);

        $this->assertEquals(20, $result['resultsCount']);
        $this->assertTrue($result['hasMoreResults']);
    }

    public function testSearchCompaniesBySubmissionDateWithBadDate(): void
    {
        $mockHandler = new MockHandler([new Response(200, [], '[]')]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->inpiRNEClient = new InpiRNEClient('fake_token', $mockedClient);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid input date format, please use YYYY-MM-DD format.');

        $this->inpiRNEClient->searchCompaniesBySubmissionDate('20204-01', '2022-042');
    }
}
