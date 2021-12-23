<?php

namespace Day02;

class Main extends \Base
{
    public function title(): string
    {
        return "Dive!";
    }

    public function one(): string
    {
        $hPos = 0;
        $depth = 0;

        for ($i = 0; $i < count($this->lines); $i++) {
            list($direction, $distance) = explode(" ", $this->lines[$i]);
            switch ($direction) {
                case "forward":
                    $hPos += $distance;
                    break;
                case "down":
                    $depth += $distance;
                    break;
                case "up":
                    $depth -= $distance;
                    break;
                default:
                    die("Bad direction");
            }
        }

        return ($hPos * $depth);
    }

    public function two(): string
    {
        $hPos = 0;
        $depth = 0;
        $aim = 0;

        for ($i = 0; $i < count($this->lines); $i++) {
            list($direction, $distance) = explode(" ", $this->lines[$i]);
            switch ($direction) {
                case "forward":
                    $hPos += $distance;
                    $depth += ($aim * $distance);
                    break;
                case "down":
                    $aim += $distance;
                    break;
                case "up":
                    $aim -= $distance;
                    break;
                default:
                    die("Bad direction");
            }
        }

        return ($hPos * $depth);
    }
}
