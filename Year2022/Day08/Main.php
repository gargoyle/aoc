<?php

namespace Year2022\Day08;

use Year2022\Lib\GridReader;
use Year2022\Lib\InputReader;

class Main
{
    private static ?self $instance = null;
    
    private GridReader $gr;
    private int $visibleCount;
    private int $highScore;
    
    public static function Title(): string
    {
        return "Treetop Tree House";
    }

    private static function getInstance(): self 
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __construct()
    {
        $data = InputReader::cleanedLines(__DIR__);
        $this->gr = new GridReader($data);
        
        $visibleCount = 0;
        $highScore = 0;
        for($x = 0; $x < $this->gr->width(); $x++) {
            for ($y = 0; $y < $this->gr->height(); $y++) {
                
                $treesNorth = iterator_to_array($this->gr->walkNorthFromLoc($x, $y));
                $treesSouth = iterator_to_array($this->gr->walkSouthFromLoc($x, $y));
                $treesEast = iterator_to_array($this->gr->walkEastFromLoc($x, $y));
                $treesWest = iterator_to_array($this->gr->walkWestFromLoc($x, $y));
                array_shift($treesNorth);
                array_shift($treesSouth); 
                array_shift($treesEast); 
                array_shift($treesWest);  
                
                $visibleCount += ($this->isVisible(
                        $x, 
                        $y, 
                        $treesNorth, 
                        $treesSouth, 
                        $treesEast, 
                        $treesWest) ? 1 : 0);
                
                $thisTree = $this->gr->atLoc($x, $y);
                $treeCounts = [
                        count($this->removeBlocked($thisTree, $treesNorth)),
                        count($this->removeBlocked($thisTree, $treesSouth)),
                        count($this->removeBlocked($thisTree, $treesEast)),
                        count($this->removeBlocked($thisTree, $treesWest))
                        ];
                $scenicScore = array_product($treeCounts);
                
                if ($scenicScore > $highScore) {
                    $highScore = $scenicScore;
                }
            }
        }
        
        $this->visibleCount = $visibleCount;
        $this->highScore = $highScore;
    }
    
    private function isVisible(int $x, int $y, array &$n, array &$s, array &$e, array &$w): bool
    {
        if ($this->gr->isEdge($x, $y)) {
            return true;
        }

        $thisTree = $this->gr->atLoc($x, $y);
        if ($this->numTallerOrEqual($thisTree, $n) == 0) {
            return true;
        }

        if ($this->numTallerOrEqual($thisTree, $s) == 0) {
            return true;
        }

        if ($this->numTallerOrEqual($thisTree, $e) == 0) {
            return true;
        }

        if ($this->numTallerOrEqual($thisTree, $w) == 0) {
            return true;
        }

        return false;
    }

    private function numTallerOrEqual(int $target, array &$candidates): int
    {
        return array_reduce($candidates, function($c, $v) use ($target){
            if ($v >= $target) { $c++; }
            return $c;
        }, 0);
    }
    
    public function removeBlocked(int $target, array $trees): array
    {
        $x = array_reduce($trees, function($visibleTrees, $v) use (&$target){
            if ($target !== -1) {
                // Only add the tree if we are not blocked.
                $visibleTrees[] = $v;
            }
            
            if ($v >= $target) {
                $target = -1; // This tree blocks us.
            }
            
            return $visibleTrees;
        }, []);
        return $x;
    }
    
    public static function TaskOne(): string
    {
        return self::getInstance()->visibleCount;
    }

    public static function TaskTwo(): string
    {
        return self::getInstance()->highScore;
    }

}
