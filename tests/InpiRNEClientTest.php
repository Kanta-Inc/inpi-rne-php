<?php

namespace InpiRNEClient;

use Mockery;
use PHPUnit\Framework\TestCase;

class InpiRNEClientTest extends TestCase
{
    protected function setUp(): void
    {
        // Initialisez InpiRNEClient avec des identifiants fictifs
        $this->inpiRNEClient = new InpiRNEClient('username', 'password');
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

    public function testSearchCompany(): void
{
    // Création du mock de l'interface
    $mock = Mockery::mock(InpiRNEClientInterface::class);
    $mockedResponse = [
        "updatedAt" => "2023-10-31T03:52:43+01:00",
        "id" => "63ade9a1e0e85a58e30d53cd",
        "formality" => [
            "siren" => "889924320",
            "content" => [
                "personneMorale" => [
                    "beneficiairesEffectifs" => [
                        [
                            "beneficiaireId" => "5",
                            "beneficiaire" => [
                                "descriptionPersonne" => [
                                    "nom" => "LEPETIT",
                                    "nationalite" => "Française"
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],
        "siren" => "889924320"
    ];

    $mock->shouldReceive('searchCompany')
         ->once()
         ->with('889924320') // SIREN fictif
         ->andReturn($mockedResponse);

    // Testez le comportement de recherche
    $result = $mock->searchCompany('889924320');
    $this->assertIsArray($result);
    $this->assertEquals('889924320', $result['siren']);
    $this->assertEquals('63ade9a1e0e85a58e30d53cd', $result['id']);
    $this->assertEquals('LEPETIT', $result['formality']['content']['personneMorale']['beneficiairesEffectifs'][0]['beneficiaire']['descriptionPersonne']['nom']);
    $this->assertEquals('Française', $result['formality']['content']['personneMorale']['beneficiairesEffectifs'][0]['beneficiaire']['descriptionPersonne']['nationalite']);
    // ... autres assertions en fonction des données retournées ...
}

    protected function tearDown(): void
    {
        Mockery::close();
    }
}