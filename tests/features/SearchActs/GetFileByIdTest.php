<?php

namespace RNEClient;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class GetFileByIdTest extends TestCase
{
    private SearchActs $RNEClient;

    protected function setUp(): void
    {
        $this->RNEClient = new SearchActs();
    }

    public function testGetFileById(): void
    {
        // get from file
        $fakeBinaryFile = 'fake_binary_file';

        $mockHandler = new MockHandler([new Response(200, [], $fakeBinaryFile)]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->RNEClient = new SearchActs('fake_token', $mockedClient);

        $data = $this->RNEClient->getFileById('idnumberzzz');

        $this->assertEquals($fakeBinaryFile, $data);
    }

    public function testGetFileByIdWithBadId(): void
    {
        $mockHandler = new MockHandler([new Response(404, [], '[]')]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->RNEClient = new SearchActs('fake_token', $mockedClient);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Not found');
        $this->RNEClient->getFileById('bad_id');
    }
}
