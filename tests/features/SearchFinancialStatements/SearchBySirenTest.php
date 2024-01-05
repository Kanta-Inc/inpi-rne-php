<?php

namespace RNEClient;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class SearchBySirenTest extends TestCase
{
    private SearchFinancialStatementsInterface $RNEClient;

    protected function setUp(): void
    {
        $this->RNEClient = new SearchFinancialStatements();
    }

    public function testSearchBySiren(): void
    {
        // get from file
        $fakeResponse = file_get_contents(__DIR__ . '/../../fixtures/SearchFinancialStatements/searchBySiren.json');

        $mockHandler = new MockHandler([new Response(200, [], $fakeResponse)]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->RNEClient = new SearchFinancialStatements('fake_token', $mockedClient);

        $data = $this->RNEClient->searchBySiren('113277693');

        $this->assertIsArray($data);
        $this->assertIsArray($data['bilans']);
        $this->assertIsArray($data['bilansSaisis']);
    }

    public function testSearchBySirenWithBadSiren(): void
    {
        $mockHandler = new MockHandler([new Response(200, [], '[]')]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->RNEClient = new SearchFinancialStatements('fake_token', $mockedClient);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid input siren, please use a 9 length number.');
        $this->RNEClient->searchBySiren('1234567890');
    }
}