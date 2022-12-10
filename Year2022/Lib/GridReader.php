<?php

namespace Year2022\Lib;

class GridReader
{
    private array $data = [];
    private int $longestRow = 0;
    
    public function __construct(array $data)
    {
        foreach ($data as $line) {
            $row = str_split($line);
            $this->data[] = $row;
            if (count($row) > $this->longestRow){ 
                $this->longestRow = count($row); 
            }
        }
    }
    
    public function atLoc(int $x, int $y)
    {
        return $this->data[$y][$x];
    }
    
    public function height(): int
    {
        return count($this->data);
    }
    
    public function width(): int
    {
        return $this->longestRow;
    }
    
    public function walkNorthFromLoc(int $x, int $y): \Generator
    {
        for ($i = $y; $i >= 0; $i--) {
            yield $this->atLoc($x, $i);
        }
    }
    
    public function walkSouthFromLoc(int $x, int $y): \Generator
    {
        for ($i = $y; $i < $this->height(); $i++) {
            yield $this->atLoc($x, $i);
        }
    }
    
    public function walkEastFromLoc(int $x, int $y): \Generator
    {
        for ($i = $x; $i < $this->width(); $i++) {
            yield $this->atLoc($i, $y);
        }
    }
    
    public function walkWestFromLoc(int $x, int $y): \Generator
    {
        for ($i = $x; $i >= 0; $i--) {
            yield $this->atLoc($i, $y);
        }
    }
    
    public function isEdge(int $x, int $y): bool
    {
        return (($x == 0) 
                || ($x == $this->width()-1) 
                || ($y == 0)
                || ($y == $this->height()-1));
    }
}
