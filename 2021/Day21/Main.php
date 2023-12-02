<?php

namespace Day21;

ini_set('memory_limit', "4096M");

class Main extends \Base
{
    public function title(): string
    {
        return "Dirac Dice";
    }

    public function one(): string
    {
        list($p1Start, $p2Start) = explode(",", $this->lines[0]);
        $p1 = new Player($p1Start);
        $p2 = new Player($p2Start);
        $die = new DtDie();


        while (true) {
            $p1->moveForward($die->roll() + $die->roll() + $die->roll());
            if ($p1->getScore() >= 1000) {
                break;
            }

            $p2->moveForward($die->roll() + $die->roll() + $die->roll());
            if ($p2->getScore() >= 1000) {
                break;
            }
        }

        return min($p1->getScore(), $p2->getScore()) * $die->getRollCount();
    }

    public function two(): string
    {
        $this->possibleRolls = [];
        for ($x = 1; $x <= 3; $x++) {
            for ($y = 1; $y <= 3; $y++) {
                for ($z = 1; $z <= 3; $z++) {
                    $this->possibleRolls[$x + $y +$z] = ($this->possibleRolls[$x + $y +$z] ?? 0) + 1;
                }
            }
        }

        $universes = [];
        $result = $this->quantumGame([7,0], [0,0], 0, $universes);
        return max($result);
    }

    /**
     * Recursively play out all the possible games. Can't use player objects as they
     * take up too much ram! :/
     */
    public function quantumGame($pos, $scores, $toggle, &$universes)
    {
        if ($scores[0] >= 21) {
            return [1, 0]; // Win for P1
        }

        if ($scores[1] >= 21) {
            return [0, 1]; // Win for P2
        }

        $key = sprintf("%s,%s,%s,%s,%s", $pos[0], $pos[1], $scores[0], $scores[1], $toggle);
        if (array_key_exists($key, $universes)) {
            return $universes[$key];
        }

        $outcome = [0,0];
        foreach ($this->possibleRolls as $k => $v) {
            $npos = $pos;
            $nscores = $scores;
            $npos[$toggle] = ($npos[$toggle] + $k) % 10;
            $nscores[$toggle] += $npos[$toggle] + 1;
            $nextSim = $this->quantumGame($npos, $nscores, ($toggle + 1) % 2, $universes);
            $outcome[0] += $v * $nextSim[0];
            $outcome[1] += $v * $nextSim[1];
        }
        $universes[$key] = $outcome;
        return $outcome;
    }
}
