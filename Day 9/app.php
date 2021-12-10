<?php

spl_autoload_register(function ($className) {
    $file = $className . '.php';
    if(file_exists($file)) {
        require_once $file;
    }
});

$begin = microtime(true);

$rows = file("input.txt");
array_walk($rows, function(&$v){ $v = trim($v); });
$lowPointRisk = [];
$basins = [];

for ($r = 0; $r < count($rows); $r++) {
    for($c = 0; $c < strlen($rows[$r]); $c++) {
        $v = (int)$rows[$r][$c];
        //printf("R= %d, C= %d, V= %d\n", $r, $c, $v);
        
        // Lower than top/bot
        $lt = !isset($rows[$r-1][$c]) || ($v < (int)$rows[$r-1][$c]);
        $lb = !isset($rows[$r+1][$c]) || ($v < (int)$rows[$r+1][$c]);
        
        // Lower than left/right
        $ll = !isset($rows[$r][$c-1]) || ($v < (int)$rows[$r][$c-1]);
        $lr = !isset($rows[$r][$c+1]) || ($v < (int)$rows[$r][$c+1]);
        
        // Push to low points list.
        if ($ll && $lr && $lb && $lt) {
            $lowPointRisk[] = $v + 1;
            $list = [];
            mapBasin($r, $c, $list);
//            print_r($list);
            $basins[] = count($list);
        }
    }
}

// Returns an array of coords corresponding to a basin. (recursivly)
function mapBasin($r,$c, &$list) {
    global $rows;
     
    $v = (int)$rows[$r][$c];
    if ($v == 9) { return; }
    if ($c < 0){ return; }
    
    // Add ourself to the list, then check adjacent locations.
    $list[] = "$r:$c";
    
    // Top
    if (isset($rows[$r-1][$c]) && !in_array($r-1 . ":" . $c, $list)) {
        mapBasin($r-1, $c, $list);
    }
    
    // Bot
    if (isset($rows[$r+1][$c]) && !in_array($r+1 . ":" . $c, $list)) {
        mapBasin($r+1, $c, $list);
    }
    
    // Left
    if (isset($rows[$r][$c-1]) && !in_array($r . ":" . $c-1, $list)) {
        mapBasin($r, $c-1, $list);
    }
        
    // Right
    if (isset($rows[$r][$c+1]) && !in_array($r . ":" . $c+1, $list)) {
        mapBasin($r, $c+1, $list);
    }
}

//print_r($basins);
rsort($basins);
//print_r($basins);
$top3 = array_slice($basins, 0, 3);
//print_r($top3);

printf("Answer 1: %d (%d low points)\n", array_sum($lowPointRisk), count($lowPointRisk));
printf("Answer 2: %d\n", array_product($top3));

printf("Runtime = %f seconds\n", 
        (microtime(true) - $begin)
        );


