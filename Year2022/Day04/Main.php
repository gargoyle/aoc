<?php

namespace Year2022\Day04;

use Year2022\Lib\InputReader;

class Main
{
    public static function Title(): string
    {
        return "Camp Cleanup";
    }

    public static function TaskOne(): string
    {
        $lines = InputReader::unbufferedCleanedLines(__DIR__);
        
        $containedCount = 0;
        foreach ($lines as $line) {
            list($r1, $r2) = explode(",", $line);
            $sr1 = new CampSectionRange(...explode('-', $r1));
            $sr2 = new CampSectionRange(...explode('-', $r2));
            
            if (CampSectionRange::Contains($sr1, $sr2)) {
                $containedCount++;
            }
        }
        
        return $containedCount;
    }
    
    public static function TaskTwo(): string
    {
        $lines = InputReader::unbufferedCleanedLines(__DIR__);
        
        $overlapCount = 0;
        foreach ($lines as $line) {
            list($r1, $r2) = explode(",", $line);
            $sr1 = new CampSectionRange(...explode('-', $r1));
            $sr2 = new CampSectionRange(...explode('-', $r2));

            if ($sr1->overlaps($sr2)) {
                $overlapCount++;
            }
        }
        
        return $overlapCount;
    }
}
