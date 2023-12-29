<?php

namespace RNEClient;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class GetMetadataByIdTest extends TestCase
{
    private SearchActs $RNEClient;

    protected function setUp(): void
    {
        $this->RNEClient = new SearchActs();
    }

    public function testGetMetadataById(): void
    {
        // get from file
        $fakeResponse = file_get_contents(__DIR__ . '/../../fixtures/SearchActs/getMetadataById.json');

        $mockHandler = new MockHandler([new Response(200, [], $fakeResponse)]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->RNEClient = new SearchActs('fake_token', $mockedClient);

        $data = $this->RNEClient->getMetadataById('idnumberzzz');
        $this->assertIsArray($data);
        $this->assertEquals('idnumberzzz', $data['id']);
        $this->assertEquals('NNNNNNNNN', $data['siren']);
    }
}
