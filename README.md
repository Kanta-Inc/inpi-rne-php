# InpiRNEClient
PHP library to access the INPI RNE API

## Description
`InpiRNEClient` is a PHP library to easily interact with RNE INPI API. It allow users to authenticate, get data about french companies with their identification number (siren number).
This version is based on the INPI Documentation located in data folder of this repository

## Installation
Use [Composer](https://getcomposer.org/) to install this package :
composer require votre/package

## Usage
Here'is a fast example to get started. If you store your token outside you can directly inject as a parameter of the InpiRNEClient Class.
If you don't provide it you have to use the authenticate method providing your username and password. This will store the token inside the InpiRNEClient Class.
Then you can get your token back with the getToken method.

```
use InpiRNEClient;

$client = new InpiRNEClient('token');
$data = $client->searchCompany('889924320');

// OR

$client = new InpiRNEClient();
$client->authenticate('votre_username', 'votre_password');
$data = $client->searchCompany('889924320');
```

## Features
- Authentication
- Get company data from their siren number

## Tests
To execute tests of the package :
vendor/bin/phpunit

## Authors
Kanta Inc
