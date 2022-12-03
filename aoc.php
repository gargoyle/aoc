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
define('MAXDAY', $argv[TEST_MODE ? 2 : 1] ?? date('d'));
define('YEAR', date('Y'));

for ($d = 1; $d <= MAXDAY; $d++) {

    $mainClass = sprintf("Year%s\Day%02s\Main", YEAR, $d);

    $title = sprintf("\n%s, Day %s: %s", YEAR, $d, $mainClass::title());
    printf("%s\n%s\n", $title, str_pad("", strlen($title), "-"));
    printf("\tPart One: %s\n", $mainClass::TaskOne());
    printf("\tPart Two: %s\n", $mainClass::TaskTwo());
}

printf(
        "\nRuntime = %f seconds\n\n",
        (microtime(true) - START_TIME)
);
