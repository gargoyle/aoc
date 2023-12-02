<?php

namespace Day18;

class Main extends \Base
{
    public function title(): string
    {
        return "Snailfish";
    }

    public function one(): string
    {
        $sfnumbers = [];
        foreach ($this->lines as $raw) {
            $code = '$line = ' . $raw . ';';
            eval($code);
            $sfnumbers[] = new SFNum($line);
        }

        $sum = array_shift($sfnumbers);
        while (!empty($sfnumbers)) {
            $leftSide = $sum;
            $rightSide = array_shift($sfnumbers);
            $sum = SFNum::createNested($leftSide, $rightSide);
            $sum->reduce();
        }

        return $sum->magnitude();
    }

    public function two(): string
    {
        $maxMag = 0;
        for ($i = 0; $i < count($this->lines)-1; $i++) {
            for ($x = $i+1; $x < count($this->lines); $x++) {
                $raw1 = $this->lines[$i];
                $raw2 = $this->lines[$x];
                $code1 = '$line1 = ' . $raw1 . ';';
                $code2 = '$line2 = ' . $raw2 . ';';
                eval($code1);
                eval($code2);

                $left = new SFNum($line1);
                $right = new SFNum($line2);
                $sum1 = SFNum::createNested($left, $right);
                $sum1->reduce();

                $left = new SFNum($line1);
                $right = new SFNum($line2);
                $sum2 = SFNum::createNested($right, $left);
                $sum2->reduce();

                if ($sum1->magnitude() >= $sum2->magnitude()) {
                    $max = $sum1;
                } else {
                    $max = $sum2;
                }

                if ($max->magnitude() > $maxMag) {
                    $maxMag = $max->magnitude();
                }
            }
        }

        return $maxMag;
    }
}
