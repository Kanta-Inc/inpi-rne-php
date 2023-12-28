<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use RNEClient\RNEClient;

$client = new RNEClient("token");

echo $client->getToken();
