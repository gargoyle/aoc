<?php

namespace Day03;

class Main extends \Base
{
    public function title(): string
    {
        return "Binary Diagnostic";
    }

    public function one(): string
    {
        $diag = new BinaryDiagnostics($this->lines);
        $oxy = BinaryDiagnostics::find($diag, 0, true);
        $scrub = BinaryDiagnostics::find($diag, 0, false);

//        echo "Power Consumption: " . $diag->powerConsumption() . PHP_EOL;
//        echo "Oxygen: " . $oxy . PHP_EOL;
//        echo "O2 Scrubber: " . $scrub . PHP_EOL;
//        echo "Life Support: " . $oxy * $scrub . PHP_EOL;

        return $diag->powerConsumption();
    }

    public function two(): string
    {
        $diag = new BinaryDiagnostics($this->lines);
        $oxy = BinaryDiagnostics::find($diag, 0, true);
        $scrub = BinaryDiagnostics::find($diag, 0, false);

        return $oxy * $scrub;
    }
}
