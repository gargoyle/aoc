<?php

namespace Day9;

class Main extends \Base
{
    private array $basins = [];
    private array $lowPointRisk = [];
    
    public function title(): string
    {
        return "Smoke Basin";
    }

    private function process()
    {
        $this->lowPointRisk = [];
        $this->basins = [];
        
        for ($r = 0; $r < count($this->lines); $r++) {
            for ($c = 0; $c < strlen($this->lines[$r]); $c++) {
                $v = (int) $this->lines[$r][$c];
                //printf("R= %d, C= %d, V= %d\n", $r, $c, $v);
                // Lower than top/bot
                $lt = !isset($this->lines[$r - 1][$c]) || ($v < (int) $this->lines[$r - 1][$c]);
                $lb = !isset($this->lines[$r + 1][$c]) || ($v < (int) $this->lines[$r + 1][$c]);

                // Lower than left/right
                $ll = !isset($this->lines[$r][$c - 1]) || ($v < (int) $this->lines[$r][$c - 1]);
                $lr = !isset($this->lines[$r][$c + 1]) || ($v < (int) $this->lines[$r][$c + 1]);

                // Push to low points list.
                if ($ll && $lr && $lb && $lt) {
                    $this->lowPointRisk[] = $v + 1;
                    $list = [];
                    $this->mapBasin($r, $c, $list);
                    $this->basins[] = count($list);
                }
            }
        }
    }

    private function mapBasin($r, $c, &$list)
    {
        $rows = $this->lines;

        $v = (int) $rows[$r][$c];
        if ($v == 9) {
            return;
        }
        if ($c < 0) {
            return;
        }

        // Add ourself to the list, then check adjacent locations.
        $list[] = "$r:$c";

        // Top
        if (isset($rows[$r - 1][$c]) && !in_array($r - 1 . ":" . $c, $list)) {
            $this->mapBasin($r - 1, $c, $list);
        }

        // Bot
        if (isset($rows[$r + 1][$c]) && !in_array($r + 1 . ":" . $c, $list)) {
            $this->mapBasin($r + 1, $c, $list);
        }

        // Left
        if (isset($rows[$r][$c - 1]) && !in_array($r . ":" . $c - 1, $list)) {
            $this->mapBasin($r, $c - 1, $list);
        }

        // Right
        if (isset($rows[$r][$c + 1]) && !in_array($r . ":" . $c + 1, $list)) {
            $this->mapBasin($r, $c + 1, $list);
        }
    }

    public function one(): string
    {
        $this->process();
        return array_sum($this->lowPointRisk);
    }

    public function two(): string
    {
        $this->process();
        rsort($this->basins);
        $top3 = array_slice($this->basins, 0, 3);
        return array_product($top3);
    }

}
