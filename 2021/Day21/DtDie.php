<?php

namespace Day21;

class DtDie
{
    public const LIMIT = 100;

    private int $nextVal = 1;

    private int $rollCount = 0;

    public function roll(): int
    {
        $this->rollCount++;

        $current = $this->nextVal++;
        if ($this->nextVal > 100) {
            $this->nextVal = 1;
        }

        return $current;
    }

    public function getRollCount(): int
    {
        return $this->rollCount;
    }
}
