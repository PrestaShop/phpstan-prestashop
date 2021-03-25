<?php

if ($argc !== 2) {
    exit('Usage: php ValidateResult/validatePHPStanOutput.php {my-json}');
}

require_once __DIR__ . '/helper.php';

$reportedJSON = json_decode($argv[1], true);

assertNumberTotalErrors($reportedJSON, 7);

assertFileHasErrorMessage(
    $reportedJSON,
    'ABCD.php',
    "Class should declare strict type.",
    5
);
assertFileHasErrorMessage(
    $reportedJSON,
    'ABCD.php',
    "Function getName should declare return type.",
    12
);
assertFileHasErrorMessage(
    $reportedJSON,
    'ABCD.php',
    "Method DummyApp\\ABCD::getName() should return int but returns string.",
    14
);
assertFileHasErrorMessage(
    $reportedJSON,
    'ABCD.php',
    "Every parameter of function toggle should be type hinted (untyped parameters: state).",
    17
);
assertFileHasErrorMessage(
    $reportedJSON,
    'ABCD.php',
    "Function toggle should declare return type.",
    17
);

assertFileHasErrorMessage(
    $reportedJSON,
    'BadTrait.php (in context of class DummyApp\ABCD)',
    'Every parameter of function whatCouldGoWrong should be type hinted (untyped parameters: a).',
    7
);
assertFileHasErrorMessage(
    $reportedJSON,
    'BadTrait.php (in context of class DummyApp\ABCD)',
    'Function whatCouldGoWrong should declare return type.',
    7
);
