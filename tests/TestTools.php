<?php

namespace InpiRne;

class TestTools
{
    /** INPI */

    public const MOCK_INPI_LOGIN_PAYLOAD =
    array(
        "token" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJleHAiOjE2ODEyMTc2NTEsInVzZXJUeXBlIjoiRk8iLCJjb25uZWN0aW9uVHlwZSI6IkFQSSIsInVzZXJJZCI6MjU0OTM4LCJ1c2VybmFt
        ZSI6ImZsYXZpZUBrYW50YS5mciIsImZpcnN0bmFtZSI6IkZsYXZpZSIsImxhc3RuYW1lIjoiRmVyYXkiLCJhY2Nlc3NUb2tlbiI6IjgxZGNiODk5MjVlY2JiZjg5YmI0ZGY3YjA2N2YwN2NlY2RiMzdiOWYiL
        CJyZWZyZXNoVG9rZW4iOiJmN2M0ZmFkNjgxZDIxYWIxNmU1MTg3NzllYWNkNThjMmZlYWY4ZmFmIiwiZXhwaXJlc0luIjo4NjQwMH0.ffQvKjbdHbF1tx4FsCbLWgWspbZDNZKKaJE1yHWgC6t_H25qPZvwpl
        ONK_4wvV5z-X20g4qu3GO5vQz7TiSFos7jwbrmzm7veJR9C4hn9SJ8bOYOsgQk5-ob4Xpw6KFFtgjp_EXwBuUfEbYWOzXjOi5Z0AvL50LPZQYXfc4PhcroIojLCikX8CyAyPf7MoC0Lfq60-EedwkcE9kC2BI
        FmW67X9kFwHmBoNMjKtwub-_PeBRjO_2g-NSNL5sOm2Qj7UIwYDmIrDDHUXE8LnABxvjCpi1_pWVHKTYQFgkTbhZ4hpK1iP6kNHJei35T9tVmeKzpZAR3JnEqGHscUuO5cG7z-pdMK7LhW-nmBFXoXvOaEPjr
        wfLAe3y2xIwGKPJKYQjCyaCHAY5xiEH8OFhwat4XhZOheUVAbEaeuOar2n8TFYuo43mWBXB9aJBIByHzVQlcWkqi_Dmr0buE9cgXaI7i7qeSDbbzWn6QFTwoNFt9qCmVBXdjyccZXkq-0SL-GhJF1xtAGhgzV
        x1Kj7FzuI_1UqfBA263k9hS5_Ys2zUf_J0XjJqrp8rBtAWiZh440DPyTxgulpDaJY-ug4AuU5IENeCYzdH4j"
    );
    // mock inpi moral person payload
    public const MOCK_INPI_COMPANY_LEGAL_ENTITY_PAYLOAD =
    array(
        "createdAt" => "2022-12-29T20:25:21+01:00",
        "updatedAt" => "2023-01-29T23:04:56+01:00",
        "id" => "63ade9a1e0e85a58e30d53cd",
        "formality" => array(
            "siren" => "889924320",
            "content" => array(
                "natureCreation" => array(
                    "dateCreation" => "2020-10-12",
                    "societeEtrangere" => false,
                    "formeJuridique" => "5710",
                    "microEntreprise" => false,
                    "etablieEnFrance" => true,
                    "salarieEnFrance" => true,
                    "relieeEntrepriseAgricole" => false,
                    "entrepriseAgricole" => false,
                    "eirl" => false
                ),
                "personneMorale" => array(
                    "identite" => array(
                        "entreprise" => array(
                            "siren" => "889924320",
                            "denomination" => "KANTA",
                            "formeJuridique" => "5710",
                            "codeApe" => "62.01Z",
                            "dateImmat" => "2020-10-12T00:00:00+02:00"
                        ),
                        "description" => array(
                            "objet" => "La programmation informatique, le développement, l'adaptation, les tests et prise en charge de logiciels. Le conseil en programmation informatique, en développement web et en communication web. Le conseil pour les affaires. La formation. La création de site web et autres applications web.",
                            "duree" => 99,
                            "dateClotureExerciceSocial" => "31 Décembre",
                            "datePremiereCloture" => "2021-06-30",
                            "ess" => true,
                            "capitalVariable" => false,
                            "montantCapital" => 21534.0,
                            "deviseCapital" => "Euros"
                        ),
                        "nomsDeDomaine" => [],
                        "entreprisesIntervenant" => []
                    ),
                    "adresseEntreprise" => array(
                        "caracteristiques" => array(
                            "ambulant" => false
                        ),
                        "adresse" => array(
                            "pays" => "FRANCE",
                            "codePostal" => "14200",
                            "commune" => "HEROUVILLE-SAINT-CLAIR",
                            "codeInseeCommune" => "14327",
                            "typeVoie" => "BD",
                            "voie" => "DES BELLES PORTES",
                            "numVoie" => "304",
                            "caracteristiques" => array(
                                "ambulant" => false
                            )
                        ),
                        "entrepriseDomiciliataire" => array()
                    ),
                    "composition" => array(
                        "pouvoirs" => [
                            array(
                                "individu" => array(
                                    "descriptionPersonne" => array(
                                        "dateDeNaissance" => "1992-10",
                                        "nom" => "LEMARIEY",
                                        "prenoms" => [
                                            "CLEMENT",
                                            "SIMON",
                                            "ALEXIS"
                                        ],
                                        "nationalite" => "Française"
                                    ),
                                    "adresseDomicile" => array(
                                        "pays" => "FRANCE",
                                        "codePostal" => "14000",
                                        "commune" => "Caen",
                                        "codeInseeCommune" => "14118"
                                    ),
                                    "conjoint" => array(
                                        "descriptionPersonne" => array()
                                    )
                                )
                            ),
                            array(
                                "entreprise" => array(
                                    "roleEntreprise" => "70",
                                    "siren" => "887722262",
                                    "denomination" => "TBLB",
                                    "formeJuridique" => "Société à responsabilité limitée"
                                ),
                                "adresseEntreprise" => array(
                                    "pays" => "FRANCE",
                                    "codePostal" => "14200",
                                    "commune" => "Hérouville-Saint-Clair",
                                    "codeInseeCommune" => "14327",
                                    "voie" => " 304 Boulevard Belles Portes"
                                ),
                                "representant" => array(
                                    "descriptionPersonne" => array(),
                                    "adresseDomicile" => array()
                                )
                            ),
                            array(
                                "individu" => array(
                                    "descriptionPersonne" => array(
                                        "dateDeNaissance" => "1991-04",
                                        "role" => "53",
                                        "nom" => "LEPETIT",
                                        "prenoms" => [
                                            "PIERRE",
                                            "RENE",
                                            "LUCIEN"
                                        ],
                                        "nationalite" => "Française"
                                    ),
                                    "adresseDomicile" => array(
                                        "pays" => "FRANCE",
                                        "codePostal" => "14000",
                                        "commune" => "Caen",
                                        "codeInseeCommune" => "14118"
                                    ),
                                    "conjoint" => array(
                                        "descriptionPersonne" => array()
                                    )
                                )
                            )
                        ]
                    ),
                    "etablissementPrincipal" => array(
                        "descriptionEtablissement" => array(
                            "rolePourEntreprise" => "2",
                            "pays" => "FRANCE",
                            "siret" => "88992432000019",
                            "activiteNonSedentaire" => false
                        ),
                        "domiciliataire" => array(),
                        "adresseDomiciliataire" => array(),
                        "adresse" => array(
                            "pays" => "FRANCE",
                            "codePostal" => "14200",
                            "commune" => "HEROUVILLE-SAINT-CLAIR",
                            "codeInseeCommune" => "14327",
                            "typeVoie" => "BD",
                            "voie" => "DES BELLES PORTES",
                            "numVoie" => "304",
                            "caracteristiques" => array(
                                "ambulant" => false
                            )
                        ),
                        "activites" => [
                            array(
                                "indicateurPrincipal" => true,
                                "indicateurProlongement" => false,
                                "dateDebut" => "2020-10-12",
                                "indicateurNonSedentaire" => false,
                                "descriptionDetaillee" => "Activité déduite de la reconstitution des données. Il vous est demandé de la reformuler.",
                                "indicateurArtisteAuteur" => false,
                                "indicateurMarinProfessionnel" => false,
                                "rolePrincipalPourEntreprise" => true,
                                "codeApe" => "62.01Z",
                                "activiteRattacheeEirl" => false,
                                "origine" => array(
                                    "typeOrigine" => "1"
                                ),
                                "buildings" => []
                            )
                        ],
                        "nomsDeDomaine" => []
                    ),
                    "autresEtablissements" => [],
                    "detailCessationEntreprise" => array(
                        "repreneurs" => []
                    ),
                    "beneficiairesEffectifs" => [
                        array(
                            "beneficiaire" => array(
                                "descriptionPersonne" => array(
                                    "dateDeNaissance" => "1992-10",
                                    "nom" => "LEMARIEY",
                                    "prenoms" => [
                                        "CLEMENT",
                                        "SIMON",
                                        "ALEXIS"
                                    ],
                                    "nationalite" => "Française"
                                ),
                                "adresseDomicile" => array(
                                    "pays" => "FRANCE"
                                )
                            ),
                            "modalite" => array(
                                "detentionPartDirecte" => false,
                                "detentionPartDirecteRdd" => 0.0,
                                "partsDirectesPleinePropriete" => 33.329999999999998,
                                "partsDirectesNuePropriete" => 0.0,
                                "detentionPartIndirecte" => false,
                                "detentionPartIndirecteRdd" => 0.0,
                                "partsIndirectesIndivision" => 0.0,
                                "partsIndirectesIndivisionPleinePropriete" => 0.0,
                                "partsIndirectesIndivisionNuePropriete" => 0.0,
                                "partsIndirectesPersonnesMorales" => 0.0,
                                "partsIndirectesPmoralesPleinePropriete" => 0.0,
                                "partsIndirectesPmoralesNuePropriete" => 0.0,
                                "detentionPartTotale" => 33.329999999999998,
                                "detentionVoteDirecte" => false,
                                "detentionVoteDirecteRdd" => 0.0,
                                "voteDirectePleinePropriete" => 33.329999999999998,
                                "voteDirecteNuePropriete" => 0.0,
                                "voteDirecteUsufruit" => 0.0,
                                "detentionVoteIndirecte" => false,
                                "detentionVoteIndirecteRdd" => 0.0,
                                "voteIndirecteIndivision" => 0.0,
                                "voteIndirecteIndivisionPleinePropriete" => 0.0,
                                "voteIndirecteIndivisionNuePropriete" => 0.0,
                                "voteIndirecteIndivisionUsufruit" => 0.0,
                                "voteIndirectePersonnesMorales" => 0.0,
                                "voteIndirectePmoralesPleinePropriete" => 0.0,
                                "voteIndirectePmoralesNuePropriete" => 0.0,
                                "voteIndirectePmoralesUsufruit" => 0.0,
                                "vocationTitulaireDirectePleineProprieteRdd" => false,
                                "vocationTitulaireDirectePleinePropriete" => 0.0,
                                "vocationTitulaireDirecteNuePropriete" => 0.0,
                                "vocationTitulaireIndirecteIndivision" => 0.0,
                                "vocationTitulaireIndirectePleineProprieteRdd" => false,
                                "vocationTitulaireIndirectePleinePropriete" => 0.0,
                                "vocationTitulaireIndirecteNuePropriete" => 0.0,
                                "vocationTitulaireIndirectePersonnesMorales" => 0.0,
                                "vocationTitulaireIndirectePmoralesPleinePropriete" => 0.0,
                                "vocationTitulaireIndirectePmoralesNuePropriete" => 0.0,
                                "detentionVoteTotal" => 33.329999999999998,
                                "detentionPouvoirDecisionAG" => false,
                                "detentionPouvoirNommageMembresConseilAdmin" => false,
                                "detentionAutresMoyensControle" => false,
                                "beneficiaireRepresentantLegal" => false,
                                "representantLegalPlacementSansGestionDelegue" => false,
                                "societeGestion" => array()
                            )
                        ),
                        array(
                            "beneficiaire" => array(
                                "descriptionPersonne" => array(
                                    "dateDeNaissance" => "1991-04",
                                    "nom" => "LEPETIT",
                                    "prenoms" => [
                                        "PIERRE",
                                        "RENE",
                                        "LUCIEN"
                                    ],
                                    "nationalite" => "Française"
                                ),
                                "adresseDomicile" => array(
                                    "pays" => "FRANCE"
                                )
                            ),
                            "modalite" => array(
                                "detentionPartDirecte" => false,
                                "detentionPartDirecteRdd" => 0.0,
                                "partsDirectesPleinePropriete" => 33.329999999999998,
                                "partsDirectesNuePropriete" => 0.0,
                                "detentionPartIndirecte" => false,
                                "detentionPartIndirecteRdd" => 0.0,
                                "partsIndirectesIndivision" => 0.0,
                                "partsIndirectesIndivisionPleinePropriete" => 0.0,
                                "partsIndirectesIndivisionNuePropriete" => 0.0,
                                "partsIndirectesPersonnesMorales" => 0.0,
                                "partsIndirectesPmoralesPleinePropriete" => 0.0,
                                "partsIndirectesPmoralesNuePropriete" => 0.0,
                                "detentionPartTotale" => 33.329999999999998,
                                "detentionVoteDirecte" => false,
                                "detentionVoteDirecteRdd" => 0.0,
                                "voteDirectePleinePropriete" => 33.329999999999998,
                                "voteDirecteNuePropriete" => 0.0,
                                "voteDirecteUsufruit" => 0.0,
                                "detentionVoteIndirecte" => false,
                                "detentionVoteIndirecteRdd" => 0.0,
                                "voteIndirecteIndivision" => 0.0,
                                "voteIndirecteIndivisionPleinePropriete" => 0.0,
                                "voteIndirecteIndivisionNuePropriete" => 0.0,
                                "voteIndirecteIndivisionUsufruit" => 0.0,
                                "voteIndirectePersonnesMorales" => 0.0,
                                "voteIndirectePmoralesPleinePropriete" => 0.0,
                                "voteIndirectePmoralesNuePropriete" => 0.0,
                                "voteIndirectePmoralesUsufruit" => 0.0,
                                "vocationTitulaireDirectePleineProprieteRdd" => false,
                                "vocationTitulaireDirectePleinePropriete" => 0.0,
                                "vocationTitulaireDirecteNuePropriete" => 0.0,
                                "vocationTitulaireIndirecteIndivision" => 0.0,
                                "vocationTitulaireIndirectePleineProprieteRdd" => false,
                                "vocationTitulaireIndirectePleinePropriete" => 0.0,
                                "vocationTitulaireIndirecteNuePropriete" => 0.0,
                                "vocationTitulaireIndirectePersonnesMorales" => 0.0,
                                "vocationTitulaireIndirectePmoralesPleinePropriete" => 0.0,
                                "vocationTitulaireIndirectePmoralesNuePropriete" => 0.0,
                                "detentionVoteTotal" => 33.329999999999998,
                                "detentionPouvoirDecisionAG" => false,
                                "detentionPouvoirNommageMembresConseilAdmin" => false,
                                "detentionAutresMoyensControle" => false,
                                "beneficiaireRepresentantLegal" => false,
                                "representantLegalPlacementSansGestionDelegue" => false,
                                "societeGestion" => array()
                            )
                        )
                    ],
                    "observations" => array(
                        "rcs" => []
                    )
                )
            ),
            "typePersonne" => "M"
        ),
        "siren" => "889924320"
    );

    // mock inpi physical person payload
    public const MOCK_INPI_COMPANY_NATURAL_PERSON_PAYLOAD =
    array(
        "createdAt" => "2022-12-28T01:52:00+01:00",
        "updatedAt" => "2023-01-28T04:20:07+01:00",
        "id" => "63ab9330d90901398e04bdcf",
        "formality" => array(
            "siren" => "448803916",
            "content" => array(
                "natureCreation" => array(
                    "dateCreation" => "2003-06-10",
                    "societeEtrangere" => false,
                    "formeJuridique" => "1000",
                    "microEntreprise" => false,
                    "etablieEnFrance" => true,
                    "salarieEnFrance" => true,
                    "relieeEntrepriseAgricole" => false,
                    "entrepriseAgricole" => false,
                    "eirl" => true
                ),
                "personnePhysique" => array(
                    "identite" => array(
                        "entreprise" => array(
                            "siren" => "448803916",
                            "formeJuridique" => "1000",
                            "nomCommercial" => "CARAMELINE PATISSERIE",
                            "codeApe" => "62.01Z",
                            "dateImmat" => "2020-10-12T00:00:00+02:00"
                        ),
                        "entrepreneur" => array(
                            "descriptionPersonne" => array(
                                "dateDeNaissance" => "1980-01",
                                "nom" => "MAUVAIS",
                                "prenoms" => [
                                    "VALERIE",
                                    "WILHELMINE"
                                ],
                                "nomUsage" => "VINCENT",
                                "nationalite" => "Française",
                            ),
                            "conjoint" => array(
                                "descriptionPersonne" => array()
                            )
                        ),
                    ),
                    "adresseEntreprise" => array(
                        "caracteristiques" => array(
                            "ambulant" => false
                        ),
                        "adresse" => array(
                            "codePostal" => "14170",
                            "commune" => "SAINT-PIERRE-EN-AUGE",
                            "codeInseeCommune" => "14654",
                            "typeVoie" => "RUE",
                            "voie" => "DU PAON",
                            "numVoie" => "5",
                            "caracteristiques" => array(
                                "ambulant" => false
                            )
                        ),
                    ),
                    "composition" => array(
                        "pouvoirs" => []
                    ),
                    "etablissementPrincipal" => array(
                        "descriptionEtablissement" => array(
                            "rolePourEntreprise" => "3",
                            "pays" => "FRANCE",
                            "siret" => "44880391600049",
                            "activiteNonSedentaire" => false,
                            "enseigne" => "DELICES GOURMANDS",
                            "nomCommercial" => "DELICES GOURMANDS"
                        ),
                        "domiciliataire" => array(),
                        "adresseDomiciliataire" => array(),
                        "adresse" => array(
                            "pays" => "FRANCE",
                            "codePostal" => "14170",
                            "commune" => "SAINT-PIERRE-EN-AUGE",
                            "codeInseeCommune" => "14654",
                            "typeVoie" => "RUE",
                            "voie" => "DU PAON",
                            "numVoie" => "5",
                            "complementLocalisation" => "Saint-Pierre-sur-Dives",
                            "caracteristiques" => array(
                                "ambulant" => false
                            )
                        ),
                        "activites" => [
                            array(
                                "indicateurPrincipal" => true,
                                "indicateurProlongement" => false,
                                "dateDebut" => "2016-09-02",
                                "indicateurNonSedentaire" => false,
                                "descriptionDetaillee" => "Activité déduite de la reconstitution des données. Il vous est demandé de la reformuler.",
                                "codeApe" => "47.24Z",
                                "activiteRattacheeEirl" => false,
                                "buildings" => []
                            ),
                            array(
                                "indicateurPrincipal" => false,
                                "dateDebut" => "2015-01-29",
                                "indicateurNonSedentaire" => false,
                                "descriptionDetaillee" => "Vente de chocolats biscuits confiseries",
                                "indicateurArtisteAuteur" => false,
                                "indicateurMarinProfessionnel" => false,
                                "codeApe" => "10.71C",
                                "activiteRattacheeEirl" => false,
                                "origine" => array(
                                    "typeOrigine" => "1"
                                ),
                                "buildings" => []
                            ),
                            array(
                                "indicateurPrincipal" => true,
                                "indicateurProlongement" => false,
                                "dateDebut" => "2003-05-01",
                                "dateFin" => "2004-09-17",
                                "exerciceActivite" => "P",
                                "indicateurNonSedentaire" => false,
                                "descriptionDetaillee" => "PATISSERIE",
                                "indicateurArtisteAuteur" => false,
                                "indicateurMarinProfessionnel" => false,
                                "codeApe" => "11.58Z",
                                "activiteRattacheeEirl" => false,
                                "origine" => array(
                                    "typeOrigine" => "3"
                                ),
                                "buildings" => []
                            )
                        ],
                        "nomsDeDomaine" => []
                    ),
                    "autresEtablissements" => [
                        array(
                            "descriptionEtablissement" => array(
                                "siret" => "44880391600049",
                            ),
                            "domiciliataire" => array(),
                            "adresseDomiciliataire" => array(),
                            "adresse" => array(
                                "pays" => "FRANCE",
                                "codePostal" => "45250",
                                "commune" => "BRIARE",
                                "codeInseeCommune" => "45053",
                                "typeVoie" => "RUE",
                                "voie" => "DE LA LIBERTE",
                                "numVoie" => "15",
                            ),
                            "activites" => [
                                array(
                                    "indicateurPrincipal" => true,
                                    "indicateurProlongement" => false,
                                    "dateDebut" => "2003-05-01",
                                    "indicateurNonSedentaire" => false,
                                    "descriptionDetaillee" => "Activité déduite de la reconstitution des données. Il vous est demandé de la reformuler.",
                                    "codeApe" => "47.24Z",
                                    "activiteRattacheeEirl" => false,
                                    "buildings" => []
                                ),
                            ],
                            "nomsDeDomaine" => []
                        ),
                        array(
                            "descriptionEtablissement" => array(
                                "siret" => "44880391600023",
                                "dateEffetFermeture" => "2015-01-29"
                            ),
                            "adresse" => array(
                                "codePostal" => "14140",
                                "commune" => "SAINT-PIERRE-EN-AUGE",
                                "codeInseeCommune" => "14654",
                                "typeVoie" => "RUE",
                                "voie" => "DU GENERAL LECLERC",
                                "numVoie" => "9"
                            ),
                            "activites" => [
                                array(
                                    "indicateurPrincipal" => true,
                                    "indicateurProlongement" => false,
                                    "dateDebut" => "2014-12-01",
                                    "descriptionDetaillee" => "Activité déduite de la reconstitution des données. Il vous est demandé de la reformuler.",
                                    "codeApe" => "47.24Z",
                                    "activiteRattacheeEirl" => false,
                                    "buildings" => []
                                ),
                                array(
                                    "indicateurPrincipal" => true,
                                    "indicateurProlongement" => false,
                                    "dateDebut" => "2010-12-01",
                                    "descriptionDetaillee" => "Activité déduite de la reconstitution des données. Il vous est demandé de la reformuler.",
                                    "codeApe" => "58.24B",
                                    "activiteRattacheeEirl" => false,
                                    "buildings" => []
                                )
                            ],
                            "nomsDeDomaine" => []
                        ),
                    ],
                    "detailCessationEntreprise" => array(
                        "repreneurs" => []
                    ),
                    "observations" => array(
                        "rcs" => []
                    )
                )
            ),
            "typePersonne" => "P"
        ),
        "siren" => "448803916"
    );

    // mock inpi act with complete metadatas payload
    public const MOCK_INPI_ACT_COMPLETE_PAYLOAD =
    [
        "id" => "63df25898640ab3541150b91",
        "siren" => "889924320",
        "denomination" => "Kanta",
        "dateDepot" => "2022-06-23",
        "numChrono" => "4861",
        "nomDocument" => "eONRoP9Tdc8d_C0022A1001L131667D20220628H202632TPIJTES003PDBOR",
        "typeRdd" => [
            [
                "typeActe" => "Décision(s) des associés",
                "decision" => "Augmentation du capital social ",
            ],
            [
                "typeActe" => "Statuts mis à jour",
            ],
            [
                "typeActe" => "Décision(s) des associés",
                "decision" => "Nomination(s) de directeur(s) général(aux) délégué(s) ",
            ],
        ],
    ];

    // mock expected act payload with complete metadatas
    public static function getExpectedActPayloadWithCompleteMetadatas()
    {
        return [
            "provider" => "inpi",
            "provider_id" => "63df25898640ab3541150b91",
            "company_siren" => "889924320",
            "company_name" => "Kanta",
            "titles" => [
                [
                    "type" => "Décision(s) des associés",
                    "decisions" => [
                        "Augmentation du capital social ",
                        "Nomination(s) de directeur(s) général(aux) délégué(s) ",
                    ],
                ],
                [
                    "type" => "Statuts mis à jour",
                    "decisions" => [],
                ],
            ],
            "filing_date" => "2022-06-23",
            "file_name" => "Kanta_Actes_23-06-2022.pdf",
        ];
    }


    // mock inpi act with incomplete metadatas payload
    public const MOCK_INPI_ACT_INCOMPLETE_PAYLOAD =
    [
        "id" => "63df25898640ab3541150b91",
        "siren" => "889924320",
        "denomination" => null,
        "dateDepot" => null,
        "numChrono" => "4861",
        "nomDocument" => "eONRoP9Tdc8d_C0022A1001L131667D20220628H202632TPIJTES003PDBOR",
        "typeRdd" => [
            [
                "typeActe" => "Décision(s) des associés",
                "decision" => "Augmentation du capital social ",
            ],
            [
                "typeActe" => "Statuts mis à jour",
            ],
            [
                "typeActe" => null,
                "decision" => "Nomination(s) de directeur(s) général(aux) délégué(s) ",
            ],
        ],
    ];

    // mock expected act payload with incomplete metadatas
    public static function getExpectedActPayloadWithIncompleteMetadatas()
    {
        return [
            "provider" => "inpi",
            "provider_id" => "63df25898640ab3541150b91",
            "company_siren" => "889924320",
            "company_name" => null,
            "titles" => [
                [
                    "type" => "Décision(s) des associés",
                    "decisions" => [
                        "Augmentation du capital social ",
                    ],
                ],
                [
                    "type" => "Statuts mis à jour",
                    "decisions" => [],
                ],
                [
                    "type" => null,
                    "decisions" => [
                        "Nomination(s) de directeur(s) général(aux) délégué(s) ",
                    ],
                ],
            ],
            "filing_date" => null,
            "file_name" => "889924320_Actes.pdf",
            "required_data_missing" => true
        ];
    }

    // mock inpi all acts metadata by siren payload
    public const MOCK_INPI_ALL_ACTS_BY_SIREN_PAYLOAD =
    [
        "actes" => [
            [
                "id" => "63df25898640ab3541150b91",
                "siren" => "889924320",
                "denomination" => "KANTA",
                "dateDepot" => "2022-06-23",
                "numChrono" => "4861",
                "nomDocument" => "eONRoP9Tdc8d_C0022A1001L131667D20220628H202632TPIJTES003PDBOR",
                "typeRdd" => [
                    [
                        "typeActe" => "Décision(s) des associés",
                        "decision" => "Augmentation du capital social "
                    ],
                    [
                        "typeActe" => "Statuts mis à jour"
                    ],
                    [
                        "typeActe" => "Décision(s) des associés",
                        "decision" => "Nomination(s) de directeur(s) général(aux) délégué(s) "
                    ]
                ]
            ],
            [
                "id" => "63df258a8640ab3541150b92",
                "siren" => "889924320",
                "denomination" => "KANTA",
                "dateDepot" => "2021-06-24",
                "numChrono" => "4986",
                "nomDocument" => "gtU346tOw8pZ_C0022A1001L188657D20210716H173749TPIJTES003PDBOR",
                "typeRdd" => [
                    [
                        "typeActe" => "Procès-verbal du conseil d'administration",
                        "decision" => "Changement relatif à la date de clôture de l'exercice social "
                    ],
                    [
                        "typeActe" => "Procès-verbal d'assemblée générale extraordinaire",
                        "decision" => "Changement relatif à la date de clôture de l'exercice social "
                    ],
                    [
                        "typeActe" => "Statuts mis à jour"
                    ],
                    [
                        "typeActe" => "Procès-verbal d'assemblée",
                        "decision" => "Changement relatif à la date de clôture de l'exercice social "
                    ]
                ]
            ],
            [
                "id" => "63df258a8640ab3541150b93",
                "siren" => "889924320",
                "denomination" => "KANTA",
                "dateDepot" => "2021-06-24",
                "numChrono" => "4986",
                "nomDocument" => "AaixZWTc1pGx_C0022A1001L120326D20210629H203721TPIJTES003PDBOR",
                "typeRdd" => [
                    [
                        "typeActe" => "Procès-verbal du conseil d'administration",
                        "decision" => "Changement relatif à la date de clôture de l'exercice social "
                    ],
                    [
                        "typeActe" => "Statuts mis à jour"
                    ],
                    [
                        "typeActe" => "Procès-verbal d'assemblée",
                        "decision" => "Changement relatif à la date de clôture de l'exercice social "
                    ],
                    [
                        "typeActe" => "Procès-verbal d'assemblée générale extraordinaire",
                        "decision" => "Changement relatif à la date de clôture de l'exercice social "
                    ]
                ]
            ],
            [
                "id" => "63df258a8640ab3541150b94",
                "siren" => "889924320",
                "denomination" => "KANTA",
                "dateDepot" => "2020-10-13",
                "numChrono" => "8218",
                "nomDocument" => "w24T8FA9sNQF_C0022A1001L633209D20201018H202929TPIJTES003PDBOR",
                "typeRdd" => [
                    [
                        "typeActe" => "Liste des souscripteurs"
                    ],
                    [
                        "typeActe" => "Attestation de dépôt des fonds et liste des souscripteurs"
                    ],
                    [
                        "typeActe" => "Statuts constitutifs"
                    ]
                ]
            ]
        ],
        "actesRbe" => [],
        "bilans" => [],
        "imrs" => [],
        "rnms" => [],
        "piecesJustificatives" => [],
        "bilansSaisis" => []
    ];

    // mock inpi all acts metadata by siren payload
    public static function getExpectedAllActsMetadatasBySiren()
    {
        return [
            [
                "provider" => "inpi",
                "provider_id" => "63df25898640ab3541150b91",
                "company_siren" => "889924320",
                "company_name" => "KANTA",
                "titles" => [
                    [
                        "type" => "Décision(s) des associés",
                        "decisions" => [
                            "Augmentation du capital social ",
                            "Nomination(s) de directeur(s) général(aux) délégué(s) ",
                        ],
                    ],
                    [
                        "type" => "Statuts mis à jour",
                        "decisions" => [],
                    ],
                ],
                "filing_date" => '2022-06-23',

                "file_name" => "KANTA_Actes_23-06-2022.pdf",
            ],
            [
                "provider" => "inpi",
                "provider_id" => "63df258a8640ab3541150b92",
                "company_siren" => "889924320",
                "company_name" => "KANTA",
                "titles" => [
                    [
                        "type" => "Procès-verbal du conseil d'administration",
                        "decisions" => [
                            "Changement relatif à la date de clôture de l'exercice social ",
                        ],
                    ],
                    [
                        "type" => "Procès-verbal d'assemblée générale extraordinaire",
                        "decisions" => [
                            "Changement relatif à la date de clôture de l'exercice social ",
                        ],
                    ],
                    [
                        "type" => "Statuts mis à jour",
                        "decisions" => [],
                    ],
                    [
                        "type" => "Procès-verbal d'assemblée",
                        "decisions" => [
                            "Changement relatif à la date de clôture de l'exercice social ",
                        ],
                    ],
                ],
                "filing_date" => '2021-06-24',
                "file_name" => "KANTA_Actes_24-06-2021.pdf",
            ],
            [
                "provider" => "inpi",
                "provider_id" => "63df258a8640ab3541150b93",
                "company_siren" => "889924320",
                "company_name" => "KANTA",
                "titles" => [
                    [
                        "type" => "Procès-verbal du conseil d'administration",
                        "decisions" => [
                            "Changement relatif à la date de clôture de l'exercice social ",
                        ],
                    ],
                    [
                        "type" => "Statuts mis à jour",
                        "decisions" => [],
                    ],
                    [
                        "type" => "Procès-verbal d'assemblée",
                        "decisions" => [
                            "Changement relatif à la date de clôture de l'exercice social ",
                        ],
                    ],
                    [
                        "type" => "Procès-verbal d'assemblée générale extraordinaire",
                        "decisions" => [
                            "Changement relatif à la date de clôture de l'exercice social ",
                        ],
                    ],
                ],
                "filing_date" => '2021-06-24',
                "file_name" => "KANTA_Actes_24-06-2021.pdf",
            ],
            [
                "provider" => "inpi",
                "provider_id" => "63df258a8640ab3541150b94",
                "company_siren" => "889924320",
                "company_name" => "KANTA",
                "titles" => [
                    [
                        "type" => "Liste des souscripteurs",
                        "decisions" => [],
                    ],
                    [
                        "type" => "Attestation de dépôt des fonds et liste des souscripteurs",
                        "decisions" => [],
                    ],
                    [
                        "type" => "Statuts constitutifs",
                        "decisions" => [],
                    ],
                ],
                "filing_date" => '2020-10-13',
                "file_name" => "KANTA_Actes_13-10-2020.pdf",
            ]
        ];
    }
}
