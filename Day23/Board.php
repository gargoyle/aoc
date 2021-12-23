<?php

namespace Day23;

class Board
{
    private array $tiles = [];

    private int $width;
    private int $height;

    private int $selectedTileIndex = -1;

    private string $lastMessage = "";
    private int $energyUsed = 0;

    private array $swaps = [];

    public function __construct(array $lines)
    {
        $this->height = count($lines);
        $this->width = strlen($lines[0]);
        $this->createTilesFromLines($lines);
    }

    public function pushSwap(Tile $a, Tile $b)
    {
        $this->swaps[] = [$a, $b];
    }

    public function undoLastSwap(): void
    {
        if (!empty($this->swaps)) {
            list($a, $b) = array_pop($this->swaps);
            $a->swapWith($b);
            $this->energyUsed -= $a->getEnergyCost();
        }
    }

    public function consumeEnergy(int $amount)
    {
        $this->energyUsed += $amount;
    }

    public function energyUsed(): int
    {
        return $this->energyUsed;
    }

    public function getMessage(): string
    {
        return $this->lastMessage;
    }

    public function setMessage(string $msg)
    {
        $this->lastMessage = $msg;
    }

    public function getTileAtCoords($x, $y): ?Tile
    {
        /** @var Tile $tile */
        foreach ($this->tiles as $tile) {
            if (($tile->getX() == $x) && ($tile->getY() == $y)) {
                return $tile;
            }
        }
        $this->lastMessage = "There is no spoon!";
        return null;
    }

    public function moveSelectedAmphipod(string $direction): void
    {
        $this->tiles[$this->selectedTileIndex]->move($direction);
    }

    public function selectNextAmphipod(): void
    {
        // Clear previous selection
        foreach ($this->tiles as $index => $tile) {
            if ($tile instanceof Amphipod) {
                $tile->deselect();
            }
        }

        // Select next tile.
        foreach ($this->tiles as $index => $tile) {
            if (($tile instanceof Amphipod) && ($index > $this->selectedTileIndex)) {
                $tile->select();
                $this->selectedTileIndex = $index;
                return;
            }
        }

        // Reached the end of the list. reset and try again.
        $this->selectedTileIndex = -1;
        $this->selectNextAmphipod();
    }

    public function render(): string
    {
        $grid = [];
        foreach ($this->tiles as $tile) {
            $tile->render($grid);
        }

        $output = '';
        for ($y = 0; $y < $this->height; $y++) {
            for ($x = 0; $x < $this->width; $x++) {
                if (!isset($grid[$x][$y])) {
                    $output .= "   ";
                } else {
                    $output .= $grid[$x][$y];
                }
            }
            $output .= "\n";
        }

        return $output;
    }

    private function createTilesFromLines($lines): void
    {
        for ($y = 0; $y < count($lines); $y++) {
            for ($x = 0; $x < strlen($lines[0]); $x++) {
                if (!isset($lines[$y][$x])) {
                    continue;
                }
                switch ($lines[$y][$x]) {
                    case 'A':
                    case 'B':
                    case 'C':
                    case 'D':
                        $this->tiles[] = new Amphipod($this, $x, $y, $lines[$y][$x]);
                        break;
                    case '#':
                        $this->tiles[] = new Wall($this, $x, $y);
                        break;
                    case '.':
                        $this->tiles[] = new EmptySpace($this, $x, $y);
                        break;
                }
            }
        }
    }
}
