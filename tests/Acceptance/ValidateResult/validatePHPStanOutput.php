<?php

if ($argc !== 2) {
    exit('Usage: php ValidateResult/validatePHPStanOutput.php {my-json}');
}

require_once __DIR__ . '/helper.php';

$reportedJSON = json_decode($argv[1], true);

assertNumberTotalErrors($reportedJSON, 1);

assertFileHasErrorMessage(
    $reportedJSON,
    'ABCD.php',
    "Method PHPStanForPrestaShopTests\\Acceptance\\DummyApp\\src\\ABCD::getName() should return int but returns string."
);
