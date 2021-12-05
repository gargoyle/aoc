<?php

spl_autoload_register(function ($className) {
    $file = $className . '.php';
    if(file_exists($file)) {
        require_once $file;
    }
});

$begin = microtime(true);

$inputData = file('test_input.txt');
$intersects = [];
$dangerPoints = [];

foreach ($inputData as $raw) {
    foreach (Line::fromVentData($raw)->points() as list($x, $y)) {
        echo "$x,$y ";
        
        if (!isset($intersects[$x][$y])) {
            $intersects[$x][$y] = 0;
        }
        $intersects[$x][$y]++;
        
        if ($intersects[$x][$y] >= 2) {
            $dangerPoints[] = $x.':'.$y;
        }
    }
    echo "\n";
}

$dangerPoints = array_unique($dangerPoints);
echo "Danger points: " . count($dangerPoints) . "\n";

printf("Runtime = %f seconds\n", 
        (microtime(true) - $begin)
        );