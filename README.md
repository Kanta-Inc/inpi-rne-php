# Inpi RNE PHP
[![Build Status](https://github.com/kanta-inc/inpi-rne-php/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/kanta-inc/inpi-rne-php/actions?query=branch%3Amain)
[![Latest Stable Version](http://poser.pugx.org/kanta-inc/inpi-rne-php/v)](https://packagist.org/packages/kanta-inc/inpi-rne-php) 
[![Total Downloads](http://poser.pugx.org/kanta-inc/inpi-rne-php/downloads)](https://packagist.org/packages/kanta-inc/inpi-rne-php) 
[![License](http://poser.pugx.org/kanta-inc/inpi-rne-php/license)](https://packagist.org/packages/kanta-inc/inpi-rne-php) 
[![PHP Version Require](http://poser.pugx.org/kanta-inc/inpi-rne-php/require/php)](https://packagist.org/packages/kanta-inc/inpi-rne-php)
[![codecov](https://codecov.io/gh/Kanta-Inc/inpi-rne-php/graph/badge.svg?token=VLK7SM56AZ)](https://codecov.io/gh/Kanta-Inc/inpi-rne-php)

PHP library to access the INPI RNE (Registre National des Entreprises)

## Description
Inpi RNE PHP is a PHP library to easily interact with RNE INPI API. It allow users to authenticate, get data about french companies with their identification number (siren number).
This version is based on the INPI Documentation located in data folder of this repository

## Requirements
PHP 8.2.0 and later.

## Installation
Use [Composer](https://getcomposer.org/) to install this package :
composer require kanta-inc/inpi-rne-php

## Usage
Here'is a fast example to get started. If you store your token outside you can directly inject as a parameter of the RNEClient Class.
If you don't provide it you have to use the authenticate method providing your username and password. This will store the token inside the RNEClient Class.
Then you can get your token back with the getToken method.

```
use RNEClient\RNEClient;

$client = new RNEClient('token');
$data = $client->searchBySiren('889924320');

// OR

$client = new RNEClient();
$client->authenticate('votre_username', 'votre_password');
$data = $client->searchBySiren('889924320');
```

## Tests
To execute tests of the package :
vendor/bin/phpunit

## Code coverage
To maintain good code quality, we encourage contributors to have the best code coverage
You have to generate the coverage report with a tool like xdebug when it's installed you can launch this command : 
```XDEBUG_MODE=coverage ./vendor/bin/phpunit --configuration phpunit.xml --coverage-clover test-reports/cov.xml```

If you use VSCode you can show it with this extension : [Coverage Gutters](https://github.com/ryanluker/vscode-coverage-gutters/)

## Authors
Kanta Inc
