<?php

namespace Day15;

class Node
{

    public int $y;
    public int $x;
    public int $cost;
    public bool $visited;
    public int $rootDistance;
    public int $distance;
    public int $mDistance;
    
    public ?Node $parent;
    
    public function __construct(int $x, int $y, int $cost, $tx, $ty)
    {
        $this->cost = $cost;
        $this->distance = PHP_INT_MAX;
        $this->rootDistance = PHP_INT_MAX;
        $this->visited = false;
        $this->x = $x;
        $this->y = $y;
        $this->parent = null;
        $this->mDistance = (2*(abs($tx - $x) + abs($ty - $y)));
    }
    
    
}
