#!/usr/bin/env php
<?php

spl_autoload_register(function ($className) {
    $base = __DIR__ . '/';

    $file = $base
          . str_replace('\\', '/', $className)
          . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

define('START_TIME', microtime(true));

$opts = getopt("t");
define('TEST_MODE', isset($opts['t']));
define('DAY', $argv[TEST_MODE ? 2 : 1] ?? 1);
define('YEAR', 2022);

//$filename = sprintf("Year%04d/Day%02d/", YEAR, DAY);
//$filename .= (TEST_MODE ? "test_" : "") . "input.txt";
//$lines = file($filename);
//array_walk($lines, function (&$v) {
//    $v = trim($v);
//});

$mainClass = sprintf("Year%s\Day%02s\Main", YEAR, DAY);

printf("\n--- %s, Day %s: %s ---\n\n", YEAR, DAY, $mainClass::title());
printf("Answer 1: %s\n", $mainClass::TaskOne());
printf("Answer 2: %s\n", $mainClass::TaskTwo());

printf(
    "\nRuntime = %f seconds\n\n",
    (microtime(true) - START_TIME)
);
