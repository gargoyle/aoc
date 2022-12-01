<?php

namespace Day13;

class Main extends \Base
{
    private $caves = [];

    public function title(): string
    {
        return "Transparent Origami";
    }

    public function one(): string
    {
        $dots = [];
        $folds = [];

        foreach ($this->lines as $line) {
            if (empty($line)) {
                continue;
            }

            if (substr($line, 0, 4) == 'fold') {
                $folds[] = $line;
            } else {
                $dots[] = $line;
            }
        }

        foreach ($folds as $fold) {
            $idx = strpos($fold, "=");
            $axis = $fold[$idx-1];
            $pos = substr($fold, $idx+1);

            for ($i = 0; $i < count($dots); $i++) {
                list($x, $y) = explode(",", $dots[$i]);
                if ($axis == "y") {
                    if ($y > $pos) {
                        $y = $pos - ($y-$pos);
                    }
                } else {
                    if ($x > $pos) {
                        $x = $pos - ($x-$pos);
                    }
                }
                $dots[$i] = "$x,$y";
            }

            break;
        }

        return count(array_unique($dots));
    }

    public function two(): string
    {
        $dots = [];
        $folds = [];

        foreach ($this->lines as $line) {
            if (empty($line)) {
                continue;
            }

            if (substr($line, 0, 4) == 'fold') {
                $folds[] = $line;
            } else {
                $dots[] = $line;
            }
        }

        foreach ($folds as $fold) {
            $idx = strpos($fold, "=");
            $axis = $fold[$idx-1];
            $pos = substr($fold, $idx+1);

            for ($i = 0; $i < count($dots); $i++) {
                list($x, $y) = explode(",", $dots[$i]);
                if ($axis == "y") {
                    if ($y > $pos) {
                        $y = $pos - ($y-$pos);
                    }
                } else {
                    if ($x > $pos) {
                        $x = $pos - ($x-$pos);
                    }
                }
                $dots[$i] = "$x,$y";
            }
        }

        $mx = 0;
        $my = 0;
        foreach ($dots as $dot) {
            list($x, $y) = explode(",", $dot);
            if ($x > $mx) {
                $mx = $x;
            }
            if ($y > $my) {
                $my = $y;
            }
        }

        $a = '';
        for ($y = 0; $y <= $my; $y++) {
            for ($x = 0; $x <= $mx; $x++) {
                $a .= in_array("$x,$y", $dots) ? "# " : ". ";
            }
            $a .= "\n";
        }

        return "\n" . $a;
    }
}
