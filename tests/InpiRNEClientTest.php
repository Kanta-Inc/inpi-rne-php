<?php

namespace InpiRNEClient;

use Mockery;
use PHPUnit\Framework\TestCase;

class InpiRNEClientTest extends TestCase
{
    private InpiRNEClientInterface $inpiRNEClient;

    protected function setUp(): void
    {
        $this->inpiRNEClient = new InpiRNEClient();
    }

    public function testInpiRNEClientInstanciation(): void
    {
        // test instanciation
        $this->inpiRNEClient = new InpiRNEClient();
        $this->assertInstanceOf(InpiRNEClient::class, $this->inpiRNEClient);
        // check token if set at instanciation
        $this->inpiRNEClient = new InpiRNEClient('my_token');
        $this->assertInstanceOf(InpiRNEClient::class, $this->inpiRNEClient);
        // check token
        $this->assertEquals('my_token', $this->inpiRNEClient->getToken());
    }

    public function testAuthentication(): void
    {
        // Création du mock de l'interface
        $mock = Mockery::mock(InpiRNEClientInterface::class);
        $mock->shouldReceive('authenticate')
            ->once()
            ->with('username', 'password');
        $mock->shouldReceive('getToken')
            ->once()
            ->andReturn('fake_token');

        // Testez le comportement de l'interface
        $mock->authenticate('username', 'password');
        $this->assertEquals('fake_token', $mock->getToken());
    }

    public function testAuthenticationWithBadCredentials(): void
    {
        // Création du mock de l'interface
        $mock = Mockery::mock(InpiRNEClientInterface::class);

        // Simulez une exception lors de l'appel à authenticate
        $mock->shouldReceive('authenticate')
            ->once()
            ->with('wrong_username', 'wrong_password')
            ->andThrow(new \Exception("Bad Credentials"));

        // Testez que l'exception est bien levée lors de l'authentification avec de mauvais identifiants
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Bad Credentials");

        $mock->authenticate('wrong_username', 'wrong_password');
    }

    public function testAuthenticationWithForbidden(): void
    {
        // Création du mock de l'interface
        $mock = Mockery::mock(InpiRNEClientInterface::class);

        // Simulez une exception lors de l'appel à authenticate
        $mock->shouldReceive('authenticate')
            ->once()
            ->with('forbidden_username', 'forbidden_password')
            ->andThrow(new \Exception("Forbidden"));

        // Testez que l'exception est bien levée lors de l'authentification avec de mauvais identifiants
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Forbidden");

        $mock->authenticate('forbidden_username', 'forbidden_password');
    }

    public function testAuthenticationWithTooManyRequests(): void
    {
        // Création du mock de l'interface
        $mock = Mockery::mock(InpiRNEClientInterface::class);

        // Simulez une exception lors de l'appel à authenticate
        $mock->shouldReceive('authenticate')
            ->once()
            ->with('too_many_requests_username', 'too_many_requests_password')
            ->andThrow(new \Exception("Too Many Requests"));

        // Testez que l'exception est bien levée lors de l'authentification avec de mauvais identifiants
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Too Many Requests");

        $mock->authenticate('too_many_requests_username', 'too_many_requests_password');
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
