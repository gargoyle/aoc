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


$filename = sprintf("Day%02d/", DAY);
$filename .= (TEST_MODE ? "test_" : "") . "input.txt";
$lines = file($filename);
array_walk($lines, function (&$v) {
    $v = trim($v);
});

$mainClassname = sprintf("Day%02s\Main", DAY);

$mainClass = new $mainClassname($lines);

printf("\n--- Day %s: %s ---\n\n", DAY, $mainClass->title());
printf("Answer 1: %s\n", $mainClass->one());
printf("Answer 2: %s\n", $mainClass->two());

printf(
    "\nRuntime = %f seconds\n\n",
    (microtime(true) - START_TIME)
);
