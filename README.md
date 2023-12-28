# InpiRNEClient
[![Build Status](https://github.com/kanta-inc/inpi-rne-php/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/kanta-inc/inpi-rne-php/actions?query=branch%3Amain)
[![Latest Stable Version](http://poser.pugx.org/kanta-inc/inpi-rne-php/v)](https://packagist.org/packages/kanta-inc/inpi-rne-php) 
[![Total Downloads](http://poser.pugx.org/kanta-inc/inpi-rne-php/downloads)](https://packagist.org/packages/kanta-inc/inpi-rne-php) 
[![License](http://poser.pugx.org/kanta-inc/inpi-rne-php/license)](https://packagist.org/packages/kanta-inc/inpi-rne-php) 
[![PHP Version Require](http://poser.pugx.org/kanta-inc/inpi-rne-php/require/php)](https://packagist.org/packages/kanta-inc/inpi-rne-php)
[![codecov](https://codecov.io/gh/Kanta-Inc/inpi-rne-php/graph/badge.svg?token=VLK7SM56AZ)](https://codecov.io/gh/Kanta-Inc/inpi-rne-php)

PHP library to access the INPI RNE API

## Description
`InpiRNEClient` is a PHP library to easily interact with RNE INPI API. It allow users to authenticate, get data about french companies with their identification number (siren number).
This version is based on the INPI Documentation located in data folder of this repository

## Installation
Use [Composer](https://getcomposer.org/) to install this package :
composer require kanta-inc/inpi-rne-php

## Usage
Here'is a fast example to get started. If you store your token outside you can directly inject as a parameter of the InpiRNEClient Class.
If you don't provide it you have to use the authenticate method providing your username and password. This will store the token inside the InpiRNEClient Class.
Then you can get your token back with the getToken method.

```
use InpiRNEClient;

$client = new InpiRNEClient('token');
$data = $client->searchCompanyBySiren('889924320');

// OR

$client = new InpiRNEClient();
$client->authenticate('votre_username', 'votre_password');
$data = $client->searchCompanyBySiren('889924320');
```

## Features
- Authentication
- Get company data from their siren number

## Tests
To execute tests of the package :
vendor/bin/phpunit

## Authors
Kanta Inc
