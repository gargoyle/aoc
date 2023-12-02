<?php

namespace Year2022\Day01;

use Year2022\Lib\InputReader;

class Main
{
    public static function Title(): string
    {
        return "Calorie Counting";
    }
    
    private static function loadElfCalories(): array
    {
        $lines = InputReader::cleanedLines(__DIR__);
        
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
