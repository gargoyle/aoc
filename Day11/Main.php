<?php

namespace Day11;

class Main extends \Base
{
    private array $octo = [];
    
    public function title(): string {
        return "Dumbo Octopus";
    }

    public function one(): string {
        for ($r = 0; $r < count($this->lines); $r++) {
            for ($c = 0; $c < strlen($this->lines[$r]); $c++) {
                $this->octo[$r][$c] = new Octopus($this->lines[$r][$c]);
            }
        }
    }

    public function two(): string {
        return "none";
    }

}