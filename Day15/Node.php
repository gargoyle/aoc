<?php

namespace Day15;

class Node
{
    private const UNVISITED_COLOR = "0;30";
    private const VISITED_COLOR = "0;32";
    private const WALKED_COLOR = "0;31";

    public int $y;
    public int $x;
    public int $cost;
    public bool $visited;
    public int $rootDistance;
    public int $distance;
    public int $mDistance;
    public bool $walked = false;

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

    public function __toString()
    {
        return sprintf(
            "\e[%sm%2s\e[0m",
            $this->walked ?
                    self::WALKED_COLOR :
                    ($this->visited ? self::VISITED_COLOR : self::UNVISITED_COLOR),
            $this->cost
        );
    }
}
