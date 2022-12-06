<?php

namespace Year2022\Day05;

use Year2022\Lib\ColumnReader;
use Year2022\Lib\InputReader;

class Main
{

    private static array $stacks = [];

    public static function Title(): string
    {
        return "Supply Stacks";
    }

    private static function InitStacks(array $data): void
    {
        $cr = new ColumnReader($data);
        $numCols = $cr->numColumns();
        for ($i = 0; $i < $numCols; $i++) {
            $column = $cr->readColumn($i);
            
            $colNum = array_pop($column);
            if ((int) $colNum == 0) {
                continue;
            }

            self::$stacks[$colNum] = array_filter($column, function ($v) {
                return !empty(trim($v));
            });
        }
    }

    private static function moveCrates(
            int $source,
            int $dest,
            int $count,
            bool $allAtOnce = false
    ): void
    {
        $pickup = array_splice(self::$stacks[$source], 0, $count, []);
        if (!$allAtOnce) {
            array_unshift(self::$stacks[$dest], ...array_reverse($pickup));
        } else {
            array_unshift(self::$stacks[$dest], ...$pickup);
        }
    }

    private static function readMessage(): string
    {
        $message = "";
        foreach (self::$stacks as $stack) {
            $message .= array_shift($stack);
        }
        return $message;
    }

    private static function parseMoveCommand(string $cmd): array
    {
        $parts = explode(' ', $cmd);
        
        $count = $parts[1];
        $source = $parts[3];
        $dest = $parts[5];
        
        return [$count, $source, $dest];
    }
    
    private static function Run(bool $allAtOnce = false): void
    {
        $lines = InputReader::unbufferedCleanedLines(__DIR__);

        $init = [];
        $initialising = true;
        foreach ($lines as $line) {
            if ($initialising) {
                if (empty(trim($line))) {
                    self::InitStacks($init);
                    $initialising = false;
                    continue;
                }
                $init[] = $line;
            } else {
                list ($count, $source, $dest) = self::parseMoveCommand($line);
                self::moveCrates($source, $dest, $count, $allAtOnce);
            }
        }
    }
    
    public static function TaskOne(): string
    {
        self::Run();
        return self::readMessage();
    }

    public static function TaskTwo(): string
    {
        self::Run(true);
        return self::readMessage();
    }

}
