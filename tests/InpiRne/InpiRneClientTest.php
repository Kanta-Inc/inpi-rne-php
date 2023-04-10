<?php

namespace InpiRne;

/**
 * Class InpiRneTest
 */
final class InpiRneClientTest extends \PHPUnit\Framework\TestCase
{
    // test
    public function testGetApiToken()
    {
        // create new InpiRne instance
        $inpiRne = new InpiRneClient();

        // set api token
        $inpiRne->setApiToken('test_123');


        $this->assertSame('test_123', InpiRneClient::getApiToken());
    }
}
