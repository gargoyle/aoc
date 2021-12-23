<?php

namespace Day05;

class Line
{
    private int $startX;
    private int $startY;
    private int $endX;
    private int $endY;

    public function __construct(int $startX, int $startY, int $endX, int $endY)
    {
        $this->startX = $startX;
        $this->startY = $startY;
        $this->endX = $endX;
        $this->endY = $endY;
    }

    public function points(): array
    {
        $points = [];
        if ($this->startX == $this->endX) {
            // line is vertical.
            foreach (range($this->startY, $this->endY) as $y) {
                $points[] = [$this->startX, $y];
            }
        } else {
            $slope = ($this->endY - $this->startY)/($this->endX - $this->startX);
            $icept = $this->startY - ($slope * $this->startX);
            foreach (range($this->startX, $this->endX) as $x) {
                $y = ($slope*$x) + $icept;
                $points[] = [$x, $y];
            }
        }
        return $points;
    }

    public static function fromVentData(string $raw)
    {
        list($start, $end) = explode("->", $raw);
        list($startX, $startY) = explode(",", $start);
        list($endX, $endY) = explode(",", $end);

        return new self((int)$startX, $startY, $endX, $endY);
    }
}
