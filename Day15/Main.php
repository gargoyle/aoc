<?php

namespace Day15;

class Main extends \Base
{
    private $maze = [];
    private $renderEnabled = false;

    public function title(): string
    {
        return "Chiton";
    }

    private function unvisitedNeighbours(int $x, int $y)
    {
        $n = [];
        $candidates = [
                $x-1 . ":" . $y,
                $x+1 . ":" . $y,
                $x . ":" . $y-1,
                $x . ":" . $y+1
                ];
        foreach ($candidates as $xy) {
            if (isset($this->maze[$xy]) && !$this->maze[$xy]->visited) {
                $n[] = $this->maze[$xy];
            }
        }
        return $n;
    }


    public function render()
    {
        if (!$this->renderEnabled) {
            return;
        }

        $xMax = strlen($this->lines[0]) * 5;
        $yMax = count($this->lines) * 5;

        echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
        for ($y = 0; $y < $yMax; $y++) {
            for ($x = 0; $x < $xMax; $x++) {
                echo $this->maze["$x:$y"];
            }
            echo "\n";
        }
    }

    public function one(): string
    {
        $x = 0;
        $y = 0;
        $goalX = strlen($this->lines[0])-1;
        $goalY = count($this->lines)-1;

        for ($x = 0; $x < strlen($this->lines[0]); $x++) {
            for ($y = 0; $y < count($this->lines); $y++) {
                $this->maze["$x:$y"] = new Node($x, $y, $this->lines[$y][$x], $goalX, $goalY);
            }
        }
        $start = $this->maze["0:0"];
        $end = $this->maze["$goalX:$goalY"];

        $queue = [];

        $start->rootDistance = 0;
        $start->distance = 0;

        $queue[] = $start;

        while (!empty($queue)) {
            /** @var Node $current */
            $current = array_pop($queue);
            $current->visited = true;

            foreach ($this->unvisitedNeighbours($current->x, $current->y) as $neighbour) {
                $minDist = min([
                        $neighbour->distance,
                        $current->distance + $neighbour->cost]);

                if ($minDist !== $neighbour->distance) {
                    $neighbour->distance = $minDist;
                    $neighbour->parent = $current;
                }

                if (!in_array($neighbour, $queue)) {
                    $queue[] = $neighbour;
                    usort($queue, function ($a, $b) {
                        return $b->distance <=> $a->distance;
                    });
                }
            }
        }

        $path = $this->walkBack($end, []);
        return array_sum($path) - $start->cost;
    }

    private function walkBack(Node $n, array $path): array
    {
        $n->walked = true;
        $path[] = $n->cost;
        if ($n->parent !== null) {
            $this->render();
            usleep(1000*60);
            return $this->walkBack($n->parent, $path);
        }
        $this->render();
        usleep(1000*60);
        return $path;
    }

    public function two(): string
    {
        $this->renderEnabled = TEST_MODE;
        $this->maze = [];
        $x = 0;
        $y = 0;
        $goalX = (strlen($this->lines[0]) * 5) - 1;
        $goalY = (count($this->lines) * 5) - 1;
        $i=0;
        for ($ry = 0; $ry < 5; $ry++) {
            for ($y = 0; $y < count($this->lines); $y++) {
                for ($rx = 0; $rx < 5; $rx++) {
                    for ($x = 0; $x < strlen($this->lines[0]); $x++) {
                        $xOffset = strlen($this->lines[0]) * $rx;
                        $yOffset = count($this->lines) * $ry;

                        $i++;
                        $xo = $x + $xOffset;
                        $yo = $y + $yOffset;

                        $value = $this->lines[$y][$x] + ($rx + $ry);
                        if ($value > 9) {
                            $value = $value - 9;
                        }
                        $this->maze["$xo:$yo"] = new Node($xo, $yo, $value, $goalX, $goalY);
                    }
                }
            }
        }

        $start = $this->maze["0:0"];
        $end = $this->maze["$goalX:$goalY"];

        $queue = [];

        $start->rootDistance = 0;
        $start->distance = 0;

        $queue[] = $start;

        while (!empty($queue)) {
            /** @var Node $current */
            $current = array_pop($queue);
            $current->visited = true;

            foreach ($this->unvisitedNeighbours($current->x, $current->y) as $neighbour) {
                $minDist = min([
                        $neighbour->distance,
                        $current->distance + $neighbour->cost]);

                if ($minDist !== $neighbour->distance) {
                    $neighbour->distance = $minDist;
                    $neighbour->parent = $current;
                }

                if (!in_array($neighbour, $queue)) {
                    $queue[] = $neighbour;
                    usort($queue, function ($a, $b) {
                        return $b->distance <=> $a->distance;
                    });
                }
            }

            if ($this->renderEnabled) {
                $this->render();
                usleep(1000*60);
            }
        }

        $path = $this->walkBack($end, []);
        return array_sum($path) - $start->cost;
    }
}
