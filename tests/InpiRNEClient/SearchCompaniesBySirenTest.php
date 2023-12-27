<?php

namespace InpiRNEClient;

use Mockery;
use PHPUnit\Framework\TestCase;

class SearchCompaniesBySirenTest extends TestCase
{
    private InpiRNEClientInterface $inpiRNEClient;

    protected function setUp(): void
    {
        $this->inpiRNEClient = new InpiRNEClient();
    }

    public function testSearchCompaniesBySiren(): void
    {
        // Création du mock de l'interface
        $mock = Mockery::mock(InpiRNEClientInterface::class);
        $mockedResponse = [
            "results" =>
            [
                [
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
                ],
                [
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
                ],
            ],
            "resultsCount" => 2,
            "hasMoreResults" => false
        ];

        // should have a token
        $mock->shouldReceive('getToken')
            ->once()
            ->andReturn('fake_token');

        $token = $mock->getToken();

        $mock->shouldReceive('searchCompaniesBySiren')
            ->once()
            ->with(['889924320', '889924320']) // SIREN fictif
            ->andReturn($mockedResponse);

        // Testez le comportement de recherche
        $result = $mock->searchCompaniesBySiren(['889924320', '889924320']);
        $this->assertIsArray($result);

        // count($result) = 2
        $this->assertCount(2, $result['results']);

        // assert decorations resultsCount == 2
        // assert decorations hasMoreResults == false
        $this->assertEquals(2, $result['resultsCount']);
        $this->assertFalse($result['hasMoreResults']);

        foreach ($result['results'] as $company) {
            $this->assertEquals('889924320', $company['siren']);
            $this->assertEquals('63ade9a1e0e85a58e30d53cd', $company['id']);
            $this->assertEquals('LEPETIT', $company['formality']['content']['personneMorale']['beneficiairesEffectifs'][0]['beneficiaire']['descriptionPersonne']['nom']);
            $this->assertEquals('Française', $company['formality']['content']['personneMorale']['beneficiairesEffectifs'][0]['beneficiaire']['descriptionPersonne']['nationalite']);
        }
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
