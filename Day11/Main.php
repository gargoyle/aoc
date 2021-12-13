<?php

namespace Day11;

class Main extends \Base
{
    private array $octo = [];
    private array $flatList = [];
    
    public function title(): string {
        return "Dumbo Octopus";
    }

    public function one(): string {
        for ($r = 0; $r < count($this->lines); $r++) {
            for ($c = 0; $c < strlen($this->lines[$r]); $c++) {
                $this->octo[$r][$c] = new Octopus($this->lines[$r][$c]);
            }
        }
        
        for ($r = 0; $r < count($this->lines); $r++) {
            for ($c = 0; $c < strlen($this->lines[$r]); $c++) {
                $this->octo[$r][$c]->setNeighbours($this->findNeighbours($r, $c));
                $this->flatList[] = $this->octo[$r][$c];
            }
        }
        
        for ($i = 0; $i < 100; $i++) {
            foreach ($this->flatList as $o) {
                $o->inc();
            }
            foreach ($this->flatList as $o) {
                $o->postInc();
            }
            foreach ($this->flatList as $o) {
                $o->cleanUp();
            }
        }
        
        $flashCount = 0;
        foreach ($this->flatList as $o) {
            $flashCount += $o->getFlashCount();
        }
        
        return $flashCount;
    }

    private function findNeighbours(int $x, int $y): array
    {
        $list = [];
        for ($r = $x-1; $r <= $x+1; $r++) {
            for ($c = $y-1; $c <= $y+1; $c++) {
                if (isset($this->octo[$r][$c])) {
                    $list[] = $this->octo[$r][$c];
                }
            }
        }
        return $list;
    }
    
    public function two(): string {
        for ($r = 0; $r < count($this->lines); $r++) {
            for ($c = 0; $c < strlen($this->lines[$r]); $c++) {
                $this->octo[$r][$c] = new Octopus($this->lines[$r][$c]);
            }
        }
        
        for ($r = 0; $r < count($this->lines); $r++) {
            for ($c = 0; $c < strlen($this->lines[$r]); $c++) {
                $this->octo[$r][$c]->setNeighbours($this->findNeighbours($r, $c));
                $this->flatList[] = $this->octo[$r][$c];
            }
        }
        
        $i = 0;
        do {
            $i++;
            $allFlashed = true;
            foreach ($this->flatList as $o) {
                $o->inc();
            }
            foreach ($this->flatList as $o) {
                $o->postInc();
            }
            foreach ($this->flatList as $o) {
                if (!$o->didFlash()) {
                    $allFlashed = false;
                }
            }
            foreach ($this->flatList as $o) {
                $o->cleanUp();
            }
        } while (!$allFlashed);
        
        return $i;
    }

}