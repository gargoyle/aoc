<?php

namespace Day23;

class Amphipod extends Tile
{
    private const SELECTED_COLOR = "0;32";
    private const COLOR = "0;31";

    private bool $selected;

    private $nrgCost = [
        'A' => 1,
        'B' => 10,
        'C' => 100,
        'D' => 1000
    ];

    private $type;

    public function getEnergyCost(): int
    {
        return $this->nrgCost[$this->type];
    }

    public function __construct(Board $board, int $x, int $y, string $type)
    {
        parent::__construct($board, $x, $y);
        $this->type = $type;
        $this->selected = false;
    }

    public function __toString()
    {
        return sprintf(
            "\e[%sm[%s]\e[0m",
            ($this->selected) ? self::SELECTED_COLOR : self::COLOR,
            $this->type
        );
    }

    public function select(): void
    {
        $this->selected = true;
    }

    public function deselect(): void
    {
        $this->selected = false;
    }

    public function move(string $direction)
    {
        switch ($direction) {
            case "UP":
                $dest = $this->board->getTileAtCoords($this->x, $this->y-1);
                break;
            case "DOWN":
                $dest = $this->board->getTileAtCoords($this->x, $this->y+1);
                break;
            case "LEFT":
                $dest = $this->board->getTileAtCoords($this->x-1, $this->y);
                break;
            case "RIGHT":
                $dest = $this->board->getTileAtCoords($this->x+1, $this->y);
                break;
        }

        if ($dest == null) {
            $this->board->setMessage("Into the void!! I don't think so.");
            return;
        }

        if ($dest instanceof Wall) {
            $this->board->setMessage("Owch!! My head.");
            return;
        }

        if ($dest instanceof Amphipod) {
            $this->board->setMessage("That's a bit too cosy for my liking!");
            return;
        }

        if ($dest instanceof EmptySpace) {
            $this->swapWith($dest);
            $this->board->consumeEnergy($this->nrgCost[$this->type]);
            $this->board->pushSwap($this, $dest);
            $this->board->setMessage("OK");
            return;
        }
    }
}
