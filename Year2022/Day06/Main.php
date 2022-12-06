<?php

namespace Year2022\Day06;

use Year2022\Lib\InputReader;

class Main
{
    public static function Title(): string
    {
        return "Tuning Trouble";
    }
    
    private static function locateMarker(int $markerLength): int
    {
        $buffer = InputReader::entireContents(__DIR__);
        $bLen = strlen($buffer);
        for ($i = 0; $i < ($bLen - $markerLength); $i++) {
            $marker = substr($buffer, $i, $markerLength);
            if (count(array_unique(str_split($marker))) == $markerLength) {
                return $i + $markerLength;
            }
        }
        
        return -1;
    }
    
    public static function TaskOne(): string
    {
        return self::locateMarker(4);
    }

    public static function TaskTwo(): string
    {
        return self::locateMarker(14);
    }
}
