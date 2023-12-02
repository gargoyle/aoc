<?php

namespace Year2022\Lib;

class InputReader
{
    const FILENAME = TEST_MODE ? 'test_input.txt' : 'input.txt';
    
    public static function cleanedLines(string $directory): array
    {
        $filename = $directory . DIRECTORY_SEPARATOR . self::FILENAME;
        
        $lines = file($filename);
        array_walk($lines, function (&$v) {
            $v = trim($v);
        });
        return $lines;
    }
    
    public static function unbufferedCleanedLines(string $directory): \Generator
    {
        $filename = $directory . DIRECTORY_SEPARATOR . self::FILENAME;
        $fp = fopen($filename, 'r');
        
        if ($fp === false) { die("Failed to open input file: " . $filename); }
        while ($line = fgets($fp)) {
            yield rtrim($line);
        }
    }
    
    public static function entireContents(string $directory): string
    {
        $filename = $directory . DIRECTORY_SEPARATOR . self::FILENAME;
        return file_get_contents($filename);
    }
}
