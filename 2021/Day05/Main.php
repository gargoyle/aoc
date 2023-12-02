<?php

namespace Day05;

class Main extends \Base
{
    public function title(): string
    {
        return "Hydrothermal Venture";
    }

    public function one(): string
    {
        return "one";
    }

    public function two(): string
    {
        $intersects = [];
        $dangerPoints = [];
        foreach ($this->lines as $raw) {
            foreach (Line::fromVentData($raw)->points() as list($x, $y)) {
                if (!isset($intersects[$x][$y])) {
                    $intersects[$x][$y] = 0;
                }
                $intersects[$x][$y]++;

                if ($intersects[$x][$y] >= 2) {
                    $dangerPoints[] = $x . ':' . $y;
                }
            }
        }
        $dangerPoints = array_unique($dangerPoints);

        return count($dangerPoints);
    }
}
