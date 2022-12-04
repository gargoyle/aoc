<?php

namespace Year2022\Day03;

use Year2022\Lib\InputReader;

class Main
{
    public static function Title(): string
    {
        return "Rucksack Reorganization";
    }

    public static function TaskOne(): string
    {
        $lines = InputReader::cleanedLines(__DIR__);
        
        $priSum = 0;
        foreach ($lines as $line) {
            $r = Rucksack::withContents($line);
            $priSum += Rucksack::TypePriority(
                    $r->commonItemType());
        }
        
        return $priSum;
    }
    
    public static function TaskTwo(): string
    {
        $lines = InputReader::cleanedLines(__DIR__);
        
        $priSum = 0;
        for ($i = 0; $i < count($lines) - 2; $i += 3) {
            $r1 = Rucksack::withContents($lines[$i]);
            $r2 = Rucksack::withContents($lines[$i+1]);
            $r3 = Rucksack::withContents($lines[$i+2]);
            
            $badge = $r1->commonItemTypeWithOtherRucksacks($r2, $r3);
            
            $priSum += Rucksack::TypePriority($badge);
        }
        
        return $priSum;
    }
}
