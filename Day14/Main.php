<?php

namespace Day14;

class Main extends \Base
{
    private $caves = [];

    public function title(): string
    {
        return "Extended Polymerization";
    }

    private function run(int $it): string
    {
        $x = $this->lines;
        $template = array_shift($x);
        $pairs = [];
        for ($i = 0; $i < (strlen($template)-1); $i++) {
            $pair = $template[$i] . $template[$i+1];
            if (!isset($pairs[$pair])) {
                $pairs[$pair] = 0;
            }
            $pairs[$pair] += 1;
        }

        $rules = [];
        foreach ($x as $line) {
            if (empty($line)) {
                continue;
            }

            list($pair, $insert) = explode(" -> ", $line);
            $rules[$pair] = $insert;
        }

        for ($s = 1; $s <= $it; $s++) {
            $newPairs = [];
            foreach ($pairs as $pair => $value) {
                if (isset($rules[$pair])) {
                    $insert = $rules[$pair];
                    if (!isset($newPairs[$pair[0].$insert])) {
                        $newPairs[$pair[0].$insert] = 0;
                    }
                    $newPairs[$pair[0].$insert] += $value;

                    if (!isset($newPairs[$insert . $pair[1]])) {
                        $newPairs[$insert . $pair[1]] = 0;
                    }
                    $newPairs[$insert . $pair[1]] += $value;
                } else {
                    if (!isset($newPairs[$pair])) {
                        $newPairs[$pair] = 0;
                    }
                    $newPairs[$pair] += $value;
                }
            }
            $pairs = $newPairs;
        }

        $elementCountsA = [];
        $elementCountsB = [];
        foreach ($pairs as $pair => $value) {
            if (!isset($elementCountsA[$pair[0]])) {
                $elementCountsA[$pair[0]] = 0;
            }
            if (!isset($elementCountsB[$pair[1]])) {
                $elementCountsB[$pair[1]] = 0;
            }
            $elementCountsA[$pair[0]] += $value;
            $elementCountsB[$pair[1]] += $value;
        }

        $merged = [];
        foreach (array_keys($elementCountsA) as $key) {
            $merged[] = max([$elementCountsA[$key], $elementCountsB[$key]]);
        }
        $max = max(array_values($merged));
        $min = min(array_values($merged));

        return ($max - $min);
    }

    public function one(): string
    {
        return $this->run(10);
    }

    public function two(): string
    {
        return $this->run(40);
    }
}
