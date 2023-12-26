<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use InpiRNEClient\InpiRNEClient;

$client = new InpiRNEClient("token");

echo $client->getToken();
