<?php

spl_autoload_register(function ($className) {
    $file = $className . '.php';
    if(file_exists($file)) {
        require_once $file;
    }
});

$begin = microtime(true);

$subData = explode(",", file_get_contents("input.txt"));
$posRange = array_reduce($subData, function($carry, $item){
    if ($item < $carry['min']) { $carry['min'] = $item; }
    if ($item > $carry['max']) { $carry['max'] = $item; }
    return $carry;
}, ['min' => PHP_INT_MAX, 'max' => 0]);

$fuelToPos = array_fill(0, $posRange['max'], 0);
for ($p = 0; $p < $posRange['max']; $p++) {
    for ($s = 0; $s < count($subData); $s++) {
        $distance = abs($p - $subData[$s]);
        for ($i = 1; $i <= $distance; $i++) {
            $fuelToPos[$p] += $i;
        }
    }
}

printf("Smallest fuel to align to pos = %d\n\n", min($fuelToPos));

printf("Runtime = %f seconds\n", 
        (microtime(true) - $begin)
        );