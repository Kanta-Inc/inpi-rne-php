<?php

namespace InpiRne;

/**
 * @internal
 * @covers \InpiRne\InpiRne
 */
final class InpiRneTest extends \PHPUnit\Framework\TestCase
{
    // test
    public function testGetApiToken()
    {
        // create new InpiRne instance
        $inpiRne = new InpiRne();

        // set api token
        $inpiRne->setApiToken('test_123');


        $this->assertSame('test_123', InpiRne::getApiToken());
    }
}
