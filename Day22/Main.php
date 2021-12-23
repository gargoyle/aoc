<?php

namespace Day22;

ini_set('memory_limit', "1024M");

class Main extends \Base
{
    public function title(): string
    {
        return "Reactor Reboot";
    }

    public function one(): string
    {
        $cubes = [];
        foreach ($this->lines as $line) {
            list($command, $x1, $x2, $y1, $y2, $z1, $z2) = $this->decodeLine($line);

            $xInRange = ($x1 >= -50) && ($x2 <=50);
            $yInRange = ($y1 >= -50) && ($y2 <=50);
            $zInRange = ($z1 >= -50) && ($z2 <=50);

            if ($xInRange && $yInRange && $zInRange) {
                for ($xc = $x1; $xc <= $x2; $xc++) {
                    for ($yc = $y1; $yc <= $y2; $yc++) {
                        for ($zc = $z1; $zc <= $z2; $zc++) {
                            $key = sprintf("%s:%s:%s", $xc, $yc, $zc);
                            $cubes[$key] = $command;
                        }
                    }
                }
            }
        }

        $states = array_count_values($cubes);
        return $states['on'];
    }

    public function two(): string
    {
        $cubes = new \SplFixedArray(count($this->lines));



        // First make a list of cubes.
        $c = 0;
        foreach ($this->lines as $line) {
            list($command, $x1, $x2, $y1, $y2, $z1, $z2) = $this->decodeLine($line);
            $cubes->offsetSet($c, new Cube($command == 'on', $x1, $x2, $y1, $y2, $z1, $z2));
            $c++;
        }

        /*
         *  Now go back over every cube and:-
         *      for an on cube, calculate its volume and remove
         */
        $onCount = 0;
        $checkedCubes = new \SplFixedArray($cubes->getSize());

        for ($i = 0; $i < $cubes->getSize(); $i++) {
            //printf("Checking cube: %d of %d            \r", $i, $cubes->getSize());
        }
        //echo "\n";

        return "Incomplete. I know i need some kind of cube intersect, just ran out of time.";
    }


    public function decodeLine($line)
    {
        $matches = [];
        $pcre = '/^(on|off)\s'
            . 'x=(-?[0-9]+)\.\.(-?[0-9]+),'
            . 'y=(-?[0-9]+)\.\.(-?[0-9]+),'
            . 'z=(-?[0-9]+)\.\.(-?[0-9]+)$/';

        if (preg_match($pcre, $line, $matches)) {
            return [
                $matches[1],
                $matches[2],$matches[3],
                $matches[4],$matches[5],
                $matches[6],$matches[7],
            ];
        }
        die("Failed to decode line!");
    }
}
