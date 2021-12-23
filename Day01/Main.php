<?php

namespace Day01;

class Main extends \Base
{
    public function title(): string
    {
        return "Sonar Sweep";
    }

    public function one(): string
    {
        $numIncreases = 0;
        for ($i = 1; $i < count($this->lines); $i++) {
            if ($this->lines[$i] > $this->lines[$i - 1]) {
                $numIncreases++;
            }
        }
        return $numIncreases;
    }

    public function two(): string
    {
        $numWindowIncreases = 0;
        $previousSum = null;

        for ($i = 2; $i < count($this->lines); $i++) {
            $sum = $this->lines[$i] + $this->lines[$i - 1] + $this->lines[$i - 2];
            if ($previousSum == null) {
                $previousSum = $sum;
                continue;
            }
            if ($sum > $previousSum) {
                $numWindowIncreases++;
            }
            $previousSum = $sum;
        }

        return $numWindowIncreases;
    }
}
