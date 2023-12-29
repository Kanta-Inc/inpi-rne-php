<?php

namespace RNEClient;


use PHPUnit\Framework\TestCase;

class ProcessXlsxDataToJsonTest extends TestCase
{
    private CategoryCodes $categoryCodes;

    protected function setUp(): void
    {
        $this->categoryCodes = new CategoryCodes();
    }

    public function testProcessXlsxDataToJson(): void
    {
        $data = $this->categoryCodes->processXlsxDataToJson();
        $this->assertIsArray($data);

        $this->assertCount(490, $data);

        $this->assertEquals('01', $data[1]['CodeN1']);
        $this->assertEquals('Agriculture, sylviculture et pêche', $data[1]['Niv. 1 ']);
        $this->assertEquals('01', $data[1]['CodeN2']);
        $this->assertEquals('Culture et élevage', $data[1]['Niv. 2']);
        $this->assertEquals('01', $data[1]['CodeN3']);
        $this->assertEquals('Culture', $data[1]['Niv. 3']);
        $this->assertEquals('02', $data[1]['CodeN4']);
        $this->assertEquals('riz', $data[1]['Niv. 4']);
        $this->assertEquals('01010102', $data[1]['Code final']);
    }

    public function testSaveJsonData(): void
    {
        $data = $this->categoryCodes->processXlsxDataToJson();
        $this->assertIsArray($data);

        $this->categoryCodes->saveJsonData($data);

        $this->assertFileExists(__DIR__ . '/../../../data/categoryCodes.json');
    }
}
