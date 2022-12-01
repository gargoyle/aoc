<?php

namespace Day24;

class Main extends \Base
{
    public function title(): string
    {
        return "Arithmetic Logic Unit";
    }

    public function one(): string
    {
        $alu = new ALU($this->lines);
        $start = 99999999999999;
        $end = 11111111111111;
        $largest = 0;

        for ($i = $start; $i >= $end; $i--) {
            echo $i . "\r";
            
            if (strpos((string)$i, "0") !== false) { continue; }

            $result = $alu->run(str_split((string)$i));
            if ($result['z'] == 0) {
                break;
            }
        }

        return $i;
    }

    public function two(): string
    {
        return "Two";
    }



}
