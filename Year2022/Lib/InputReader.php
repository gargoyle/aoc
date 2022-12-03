<?php

namespace Year2022\Lib;

class InputReader
{
    public static function cleanedLines(string $filename): array
    {
        $lines = file($filename);
        array_walk($lines, function (&$v) {
            $v = trim($v);
        });
        return $lines;
    }
}
