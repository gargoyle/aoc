<?php

$input = file('day2_input.txt');

$hPos = 0;
$depth = 0;

for ($i = 0; $i < count($input); $i++) {
    list($direction, $distance) = explode(" ", $input[$i]);
    switch ($direction) {
        case "forward":
            $hPos += $distance;
            break;
        case "down":
            $depth += $distance;
            break;
        case "up":
            $depth -= $distance;
            break;
        default:
            die("Bad direction");
    }
}

printf("Answer 1: depth = %d, position = %d (%d)\n",
        $depth, $hPos, ($hPos * $depth));

$hPos = 0;
$depth = 0;
$aim = 0;

for ($i = 0; $i < count($input); $i++) {
    list($direction, $distance) = explode(" ", $input[$i]);
    switch ($direction) {
        case "forward":
            $hPos += $distance;
            $depth += ($aim * $distance);
            break;
        case "down":
            $aim += $distance;
            break;
        case "up":
            $aim -= $distance;
            break;
        default:
            die("Bad direction");
    }
    
}

printf("Answer 1: depth = %d, position = %d (%d)\n",
        $depth, $hPos, ($hPos * $depth));