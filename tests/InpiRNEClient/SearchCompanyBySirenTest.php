<?php

namespace InpiRNEClient;

use Mockery;
use PHPUnit\Framework\TestCase;

class SearchCompanyBySirenTest extends TestCase
{
    private InpiRNEClientInterface $inpiRNEClient;

    protected function setUp(): void
    {
        $this->inpiRNEClient = new InpiRNEClient();
    }

    public function testSearchCompanyBySiren(): void
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

        // should have a token
        $mock->shouldReceive('getToken')
            ->once()
            ->andReturn('fake_token');

        $token = $mock->getToken();

        $mock->shouldReceive('searchCompanyBySiren')
            ->once()
            ->with('889924320') // SIREN fictif
            ->andReturn($mockedResponse);

        // Testez le comportement de recherche
        $result = $mock->searchCompanyBySiren('889924320');
        $this->assertIsArray($result);
        $this->assertEquals('889924320', $result['siren']);
        $this->assertEquals('63ade9a1e0e85a58e30d53cd', $result['id']);
        $this->assertEquals('LEPETIT', $result['formality']['content']['personneMorale']['beneficiairesEffectifs'][0]['beneficiaire']['descriptionPersonne']['nom']);
        $this->assertEquals('Française', $result['formality']['content']['personneMorale']['beneficiairesEffectifs'][0]['beneficiaire']['descriptionPersonne']['nationalite']);
    }

    public function testSearchCompanyBySirenWithBadSiren(): void
    {
        $client = new InpiRNEClient();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid input siren, please use a 9 length number.");
        $client->searchCompanyBySiren('bad_siren');
    }

    public function testSearchCompanyBySirenWithShortSiren(): void
    {
        $client = new InpiRNEClient();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid input siren, please use a 9 length number.");
        $client->searchCompanyBySiren('12345678');
    }

    public function testSearchCompanyBySirenWithLongSiren(): void
    {
        $client = new InpiRNEClient();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid input siren, please use a 9 length number.");
        $client->searchCompanyBySiren('1234567890');
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
