<?php

namespace Day11;

class Octopus
{
    private array $neighbours;

    private int $energy;

    private bool $flashing;

    private int $flashCount;

    public function __construct(int $energy)
    {
        $this->energy = $energy;
        $this->flashCount = 0;
        $this->flashing = false;
    }

    public function setNeighbours(array $neighbours)
    {
        $this->neighbours = $neighbours;
    }

    public function inc($check = false): void
    {
        $this->energy++;
        if ($check) {
            $this->postInc();
        }
    }

    public function postInc(): void
    {
        if (($this->energy > 9) && (!$this->flashing)) {
            $this->flash();
        }
    }

    public function didFlash(): bool
    {
        return $this->flashing;
    }

    public function cleanUp(): void
    {
        if ($this->flashing) {
            $this->energy = 0;
            $this->flashing = false;
        }
    }

    private function flash(): void
    {
        $this->flashCount++;
        $this->flashing = true;
        foreach ($this->neighbours as $o) {
            $o->inc(true);
        }
    }

    public function getFlashCount(): int
    {
        return $this->flashCount;
    }
}
