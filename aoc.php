#!/usr/bin/env php
<?php

spl_autoload_register(function ($className) {
    $base = __DIR__ . '/';
    
    $file = $base
          . str_replace('\\', '/', $className)
          . '.php';
    
    if(file_exists($file)) {
        require_once $file;
    }
});

define('START_TIME', microtime(true));

$opts = getopt("t");
define('TEST_MODE', isset($opts['t']));
define('DAY', $argv[TEST_MODE ? 2 : 1] ?? 1);


$filename = "Day" . DAY . "/";
$filename .= (TEST_MODE ? "test_" : "") . "input.txt";
$lines = file($filename);
array_walk($lines, function(&$v){ $v = trim($v); });

$mainClassname = sprintf("Day%s\Main", DAY);

$main = new $mainClassname($lines);

printf("\n--- Day %s: %s ---\n\n", DAY, $main->title());
printf("Answer 1: %d\n", $main->one());
printf("Answer 2: %d\n", $main->two());

printf("\nRuntime = %f seconds\n\n", 
        (microtime(true) - START_TIME)
        );

