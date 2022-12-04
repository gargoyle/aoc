#!/usr/bin/env php
<?php

spl_autoload_register(function ($className) {
    $base = dirname(__DIR__) . '/';

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
$customDay = $argv[TEST_MODE ? 2 : 1] ?? false;
if ($customDay) {
    define('MAXDAY', $customDay);
    define('MINDAY', $customDay);
} else {
    define('MAXDAY', date('d'));
    define('MINDAY', 1);
}
define('YEAR', date('Y'));

system('figlet AoC 2022');
for ($d = MINDAY; $d <= MAXDAY; $d++) {
    $mainClass = sprintf("Year%s\Day%02s\Main", YEAR, $d);

    $title = sprintf("\nDay %s: %s", $d, $mainClass::title());
    printf("%s\n%s\n", $title, str_pad("", strlen($title)-1, "-"));
    printf("\tPart One: %s\n", $mainClass::TaskOne());
    printf("\tPart Two: %s\n", $mainClass::TaskTwo());
}

$stats = [
        'Memory (MB)' => memory_get_peak_usage(true) / 1048576.0,
        'Runtime (s)' => (microtime(true) - START_TIME)
];

echo "\n\nStats\n-----\n";
foreach ($stats as $k => $v) {
    printf("% 16s: %1.4f\n", $k, $v);
}
