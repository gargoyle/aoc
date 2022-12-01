<?php

namespace Year2022\Day01;

class Main
{
    public static function Title(): string
    {
        return "Calorie Counting";
    }
    
    private static function cleanedLines(): array
    {
        $filename = __DIR__ . DIRECTORY_SEPARATOR . (TEST_MODE ? "test_" : "") . "input.txt";
        $lines = file($filename);
        array_walk($lines, function (&$v) {
            $v = trim($v);
        });
        return $lines;
    }
    
    private static function loadElfCalories(): array
    {
        $lines = self::cleanedLines();
        
        $elfCalories = [];
        $elfNum = 1;
        $currentCals = 0;
        
        for ($i = 0; $i < count($lines); $i++) {
            $currentCals += (int) $lines[$i];
            
            if ($lines[$i] == "") {
                $elfCalories[$elfNum] = $currentCals;
                $currentCals = 0;
                $elfNum++;
            }
        }
        $elfCalories[$elfNum] = $currentCals;
        
        return $elfCalories;
    }
    
    public static function TaskOne(): string
    {
        $elfCalories = self::loadElfCalories();
        asort($elfCalories);

        return array_pop($elfCalories);
    }
    
    public static function TaskTwo(): string
    {
        $elfCalories = self::loadElfCalories();
        arsort($elfCalories);
        $topThree = array_slice($elfCalories, 0, 3);
        
        return array_sum($topThree);
    }
}
