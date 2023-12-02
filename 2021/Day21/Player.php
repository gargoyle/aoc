<?php

namespace Day21;

class Player
{
    private int $pos;
    private int $score;

    public function __construct(int $start)
    {
        $this->pos = $start;
        $this->score = 0;
    }

    public function moveForward(int $num)
    {
        $toAdv = $num % 10;
        $newPos = $this->pos + $toAdv;
        if ($newPos > 10) {
            $newPos = $newPos - 10;
        }

        $this->pos = $newPos;
        $this->score += $this->pos;
    }

    public function getScore(): int
    {
        return $this->score;
    }



    public function __toString()
    {
        return sprintf("%s:%s", $this->pos, $this->score);
    }
}
