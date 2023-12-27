<?php

namespace InpiRNEClient;

use Mockery;
use PHPUnit\Framework\TestCase;

class InpiRNEClientTest extends TestCase
{
    /**
     * @var InpiRNEClientInterface
     */
    private InpiRNEClientInterface $inpiRNEClient;

    protected function setUp(): void
    {
        // Initialisez InpiRNEClient avec des identifiants fictifs
        $this->inpiRNEClient = new InpiRNEClient();
    }

    public function testInit(): void
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

    public function testSearchCompanyByZipCode(): void
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

        $mock->shouldReceive('searchCompanyByZipCode')
            ->once()
            ->with('75001') // Code postal fictif
            ->andReturn($mockedResponse);

        // Testez le comportement de recherche
        $result = $mock->searchCompanyByZipCode('75001');
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
