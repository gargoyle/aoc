<?php

namespace Day03;

class BinaryDiagnostics
{
    private array $input;

    public function __construct(array $input)
    {
        $this->input = $input;
    }

    private function maxColWidth(): int
    {
        $maxWidth = array_reduce($this->input, function ($carry, $item) {
            return strlen($item) > $carry ? strlen($item) : $carry;
        }, 0);

        return $maxWidth;
    }

    public function stats(): array
    {
        $stats = [
                'num rows' => count($this->input),
                'num cols' => $this->maxColWidth(),
                'cols' => []
        ];

        $ones = $zeros = 0;
        for ($i = 0; $i < $this->maxColWidth(); $i++) {
            $colStats = array_reduce(
                $this->input,
                function ($carry, $item) use ($i) {
                        if ($item[$i] == '1') {
                            $carry['ones']++;
                        } else {
                            $carry['zeros']++;
                        }
                        return $carry;
                    },
                ['zeros' => 0, 'ones' => 0]
            );
            $stats['cols'][$i] = $colStats;
        }
        return $stats;
    }

    public function gamma(): int
    {
        $gamma = '';
        $stats = $this->stats();
        for ($i = 0; $i < $this->maxColWidth(); $i++) {
            $isOne = $stats['cols'][$i]['ones'] > $stats['cols'][$i]['zeros'];
            $gamma .= $isOne ? '1' : '0';
        }
        return bindec($gamma);
    }

    public function epsilon(): int
    {
        $epsilon = '';
        $stats = $this->stats();
        for ($i = 0; $i < $this->maxColWidth(); $i++) {
            $isOne = $stats['cols'][$i]['ones'] < $stats['cols'][$i]['zeros'];
            $epsilon .= $isOne ? '1' : '0';
        }
        return bindec($epsilon);
    }

    public function powerConsumption(): int
    {
        return $this->gamma() * $this->epsilon();
    }

    public function reduceByColumnValue($column, $valueToKeep): self
    {
        $reduced = array_filter($this->input, function ($value) use ($column, $valueToKeep) {
            return $value[$column] == $valueToKeep;
        });
        return new self(array_values($reduced));
    }

    public function count(): int
    {
        return count($this->input);
    }

    public function getValue($index = 0): int
    {
        return bindec($this->input[$index]);
    }

    public static function find(BinaryDiagnostics $diag, $i = 0, $oxy = true)
    {
        if ($i > $diag->maxColWidth()) {
            die("Exceeded column width and didn't find value");
        }

        if ($diag->count() == 1) {
            return $diag->getValue();
        }

        $stats = $diag->stats();
        $isOne = $stats['cols'][$i]['ones'] >= $stats['cols'][$i]['zeros'];
        if (!$oxy) {
            $isOne = !$isOne;
        }

        $toKeep = ($isOne) ? '1' : '0';
        $reduced = $diag->reduceByColumnValue($i, $toKeep);

        $i++;
        return self::find($reduced, $i, $oxy);
    }
}
