<?php

spl_autoload_register(function ($className) {
    $file = $className . '.php';
    if(file_exists($file)) {
        require_once $file;
    }
});

$begin = microtime(true);

$days = $argv[1] ?? 80;
printf("Simulating Lanternfish for %d days...\n\n", $days);

$fishData = explode(",", file_get_contents("input.txt"));

for($i = 0; $i <= 8; $i++) {
    $fishAtTimer[$i] = 0;
}
foreach ($fishData as $fish) {
    $fishAtTimer[$fish]++;
}

for ($d = 1; $d <= $days; $d++) {
    // Fish at timer 0 are ready to spawn.
    $spawningFish = $fishAtTimer[0];
    
    // Shunt other fish down a group.
    for($i = 1; $i <= 8; $i++) {
        $fishAtTimer[$i-1] = $fishAtTimer[$i];
    }
    
    // Add the same number of new fish as spawning fish to group 8
    $fishAtTimer[8] = $spawningFish;
    
    // Append spawning fish to group 6.
    $fishAtTimer[6] += $spawningFish;
}

printf("Total fish: %d\n\n", array_sum($fishAtTimer));

printf("Runtime = %f seconds\n", 
        (microtime(true) - $begin)
        );