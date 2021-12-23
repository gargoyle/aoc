<?php

namespace Day17;

class Probe
{
    private int $yVel;
    private int $xVel;
    public int $x;
    public int $y;
    public int $maxAlt;

    public function __construct(int $xVel, int $yVel)
    {
        $this->xVel = $xVel;
        $this->yVel = $yVel;
        $this->x = 0;
        $this->y = 0;
        $this->maxAlt = 0;
    }

    public function tick(): void
    {
        $this->x += $this->xVel;
        $this->y += $this->yVel;

        if ($this->y > $this->maxAlt) {
            $this->maxAlt = $this->y;
        }

        if ($this->xVel !== 0) {
            $this->xVel += ($this->xVel > 0 ? -1 : +1);
        }

        $this->yVel -= 1;
    }

    public function status(): string
    {
        return sprintf(
            "Position = %d:%d, Speed = %d:%d\n",
            $this->x,
            $this->y,
            $this->xVel,
            $this->yVel
        );
    }
}
