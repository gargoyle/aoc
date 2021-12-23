<?php

namespace Day23;

abstract class Tile
{
    protected Board $board;
    protected int $x;
    protected int $y;

    public function __construct(Board $board, int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
        $this->board = $board;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function render(array &$grid): void
    {
        $grid[$this->x][$this->y] = (string)$this;
    }

    abstract public function __toString(): string;

    public function swapWith(Tile $other)
    {
        $tmpx = $other->x;
        $tmpy = $other->y;
        $other->x = $this->x;
        $other->y = $this->y;
        $this->x = $tmpx;
        $this->y = $tmpy;
    }
}
