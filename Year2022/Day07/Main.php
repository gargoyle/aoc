<?php

namespace Year2022\Day07;

class Main
{
    
    
    public static function Title(): string
    {
        return "No Space Left On Device";
    }

    public static function TaskOne(): string
    {
        $input = \Year2022\Lib\InputReader::cleanedLines(__DIR__);
        $fs = new Filesystem($input);
        
        $totalSize = 0;
        foreach ($fs->flat() as $item) {
            if (($item instanceof Directory) && ($item->size() <= 100000)) {
                $totalSize += $item->size();
            }
        }
        
        return $totalSize;
    }

    public static function TaskTwo(): string
    {
        $input = \Year2022\Lib\InputReader::cleanedLines(__DIR__);
        $fs = new Filesystem($input);
        $target = 30000000;
        $freeSpace = $fs->freeSpace();
        
        $smallestDirToReachTarget = null; 
        foreach ($fs->flat() as $item) {
            $willReachTarget = (($freeSpace + $item->size()) >= $target);
            if (($item instanceof Directory) && $willReachTarget) {
                if ($smallestDirToReachTarget == null) {
                    $smallestDirToReachTarget = $item;
                }
                
                if ($item->size() < $smallestDirToReachTarget->size()) {
                    $smallestDirToReachTarget = $item;
                }
            }
        }
        
        return $smallestDirToReachTarget->size();
    }

}
