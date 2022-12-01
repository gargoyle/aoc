<?php

namespace Day24;

use RuntimeException;

class ALU
{
    private $w = 0;
    private $x = 0;
    private $y = 0;
    private $z = 0;

    private array $inputBuffer;
    private array $commandList;

    public function __construct(array $commandList)
    {
        $this->commandList = $commandList;
    }

    public function run(array $inputBuffer)
    {
        try {
            $this->inputBuffer = $inputBuffer;

            foreach ($this->commandList as $index => $command) {
                $args = explode(" ", $command);
                $instruction = array_shift($args);
                if (!method_exists($this, $instruction)) {
                    throw new RuntimeException(sprintf("No such ALU instruction: %s", $instruction));
                }
                $this->$instruction(...$args);
            }
        } catch (\Exception $e) {
            printf("ALU failed with: %s\n\tIndex: %s\n\tArgs: %s\n",
                $e->getMessage(), $index, implode(",", $args));

            print_r($this);
        }

        return [
            'w' => $this->w,
            'x' => $this->x,
            'y' => $this->y,
            'z' => $this->z,
        ];
    }

    private function inp(string $destinationVar)
    {
        if (empty($this->inputBuffer)) {
            throw new RuntimeException("Attempt to read from an empty input buffer.");
        }
        $this->$destinationVar = array_shift($this->inputBuffer);
    }

    private function add($a, $b)
    {
        if (is_numeric($b))
            $this->$a = gmp_add($this->$a, $b);
        else
            $this->$a = gmp_add($this->$a, $this->$b);
    }

    private function mul($a, $b)
    {
        if (is_numeric($b))
            $this->$a = gmp_mul($this->$a, $b);
        else
            $this->$a = gmp_mul($this->$a, $this->$b);
    }

    private function div($a, $b)
    {
        if (is_numeric($b)) {
            if ($b == 0) { throw new RuntimeException("ALU cannot devide by zero!"); }
            $this->$a = gmp_div_q($this->$a, $b);
        } else {
            if ($this->$b == 0) { throw new RuntimeException("ALU cannot devide by zero!"); }
            $this->$a = gmp_div_q($this->$a, $this->$b);
        }
    }

    private function mod($a, $b)
    {
        if ($this->$a < 0) {
            throw new RuntimeException("ALU cannot modulo zero!");
        }

        if (is_numeric($b)) {
            if ($b <= 0) { throw new RuntimeException("ALU cannot modulo by a value less than zero!"); }
            $this->$a = gmp_mod($this->$a, $b);
        } else {
            if ($this->$b <= 0) { throw new RuntimeException("ALU cannot modulo by a value less than zero!"); }
            $this->$a = gmp_mod($this->$a, $this->$b);
        }
    }

    private function eql($a, $b)
    {
        if (is_numeric($b))
            $this->$a = ($this->$a == $b);
        else
            $this->$a = ($this->$a == $this->$b);
    }
}