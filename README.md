# InpiRNEClient
PHP library to access the INPI RNE API

## Description
`InpiRNEClient` est un package PHP pour interagir facilement avec l'API RNE de l'INPI. Il permet aux utilisateurs de s'authentifier, de rechercher des informations sur les entreprises françaises, et de manipuler d'autres données fournies par l'API.

## Installation
Utilisez Composer pour installer ce package :
composer require votre/package

## Utilisation
Voici un exemple rapide pour commencer, si vous avez un token vous pouvez l'injecter directement.
Sinon il faut également s'authentifier, le token reste en mémoire dans l'objet, afin d'optimiser l'utilisation du token il faut le stocker à l'exterieur pour limiter la regeneration de token et le trafic vers l'INPI.

use InpiRNEClient;

$client = new InpiRNEClient('token');


Authentification (génération d'un token), ceci est indispensable pour utiliser les autres actions si vous n'aviez pas injecté le token à la creation du Client.
$client->authenticate('votre_username', 'votre_password');

$companyData = $client->searchCompany('889924320');

## Fonctionnalités
- Authentification à l'API RNE de l'INPI.
- Recherche d'informations sur les entreprises par SIREN.

## Tests
Pour exécuter les tests :
vendor/bin/phpunit

## Contribution
Les contributions sont les bienvenues. Veuillez soumettre vos pull requests à la branche `main`.

## Licence
Ce projet est sous licence MIT.

## Authors
Kanta Inc
