<?php

namespace InpiRne;

/**
 * Class InpiRneTest
 */
final class InpiRneClientTest extends \PHPUnit\Framework\TestCase
{

    protected $inpiRne;

    public function __construct()
    {
        $this->inpiRne = new MockInpiRneClient();

        parent::__construct();
    }
    // test
    public function testGetApiToken()
    {
        // set api token
        $this->inpiRne->setApiToken('test_123');


        $this->assertSame('test_123', $this->inpiRne->getApiToken());
    }

    // test login
    public function testLogin()
    {
        $response = $this->inpiRne->login('username', 'password');
        // assert response is successful
        $this->assertNotNull($response);
    }

    // test get company
    public function testGetCompany()
    {
        $response = $this->inpiRne->login('flavie@kanta.fr', 'inpiDEMO!2023');
        $response = $this->inpiRne->getCompany('113277693');

        // assert response is successful
        $this->assertNotNull($response);
    }
}
