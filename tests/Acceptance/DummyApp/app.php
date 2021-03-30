<?php

use DummyApp\ABCD;

require_once __DIR__ . '/autoload.php';

$a = '';
$b = new ABCD();
$c = $b->getName();

echo "Goodbye";
