<?php

namespace Day22;

class Cube
{
    private int $zMax;
    private int $zMin;
    private int $yMax;
    private int $yMin;
    private int $xMax;
    private int $xMin;
    private bool $isOn;

    public function __construct(bool $isOn, int $xMin, int $xMax, int $yMin, int $yMax, int $zMin, int $zMax)
    {
        $this->isOn = $isOn;
        $this->xMin = $xMin;
        $this->xMax = $xMax;
        $this->yMin = $yMin;
        $this->yMax = $yMax;
        $this->zMin = $zMin;
        $this->zMax = $zMax;
    }

    public function containsPoint(int $x, int $y, int $z)
    {
        return (
            ($x >= $this->xMin && $x <= $this->xMax) &&
            ($y >= $this->xMin && $y <= $this->yMax) &&
            ($z >= $this->zMin && $z <= $this->zMax));
    }

    public function intersectsWith(Cube $other)
    {
        return (
            ($other->xMin <= $this->xMax && $other->xMax >= $this->xMin) &&
            ($other->yMin <= $this->yMax && $other->yMax >= $this->yMin) &&
            ($other->zMin <= $this->zMax && $other->zMax >= $this->zMin));
    }

    public function isOn(): bool
    {
        return $this->isOn;
    }

    public function numPoints(): int
    {
        return ($this->xMax - $this->xMin) * ($this->yMax - $this->yMin) * ($this->zMax - $this->zMin);
    }

    public function points()
    {
        for ($x = $this->xMin; $x <= $this->xMax; $x++) {
            for ($y = $this->yMin; $y <= $this->yMax; $y++) {
                for ($z = $this->zMin; $z <= $this->zMax; $z++) {
                    yield [$x, $y, $z];
                }
            }
        }
    }
}
