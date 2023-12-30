<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use RNEClient\CategoryCodes;

$categoryCodes = new CategoryCodes();

$data = $categoryCodes->processXlsxDataToJson();
$categoryCodes->saveJsonData($data);
