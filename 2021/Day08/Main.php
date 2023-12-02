<?php

namespace Day08;

class Main extends \Base
{
    public function title(): string
    {
        return "Seven Segment Search";
    }

    public function one(): string
    {
        $data = [];
        foreach ($this->lines as $line) {
            list($input, $output) = explode("|", trim($line));
            $signals = array_filter(explode(" ", $input));
            array_walk($signals, function (&$v) {
                $v = str_split($v);
            });
            $display = array_filter(explode(" ", $output));
            array_walk($display, function (&$v) {
                $v = str_split($v);
            });
            $data[] = [
                'input' => $signals,
                'output' => $display
            ];
        }

        $count = array_reduce($data, function ($carry, $item) {
            foreach ($item['output'] as $signal) {
                switch (count($signal)) {
                    case 2: // 1
                    case 3: // 7
                    case 4: // 4
                    case 7: // 8
                        $carry++;
                        break;
                }
            }
            return $carry;
        }, 0);

        return $count;
    }

    public function two(): string
    {
        $data = [];
        foreach ($this->lines as $line) {
            list($input, $output) = explode("|", trim($line));
            $signals = array_filter(explode(" ", $input));
            array_walk($signals, function (&$v) {
                $v = str_split($v);
            });
            $display = array_filter(explode(" ", $output));
            array_walk($display, function (&$v) {
                $v = str_split($v);
            });
            $data[] = [
                'input' => $signals,
                'output' => $display
            ];
        }

        $display = [
            1 => "cf",
            7 => "acf",
            4 => "bcdf",
            2 => "acdeg",
            3 => "acdfg",
            5 => "abdfg",
            0 => "abcefg",
            6 => "abdefg",
            9 => "abcdfg",
            8 => "abcdefg",
        ];
        $rDisplay = array_flip($display);
        $mapping = array_fill_keys(['a', 'b', 'c', 'd', 'e', 'f', 'g'], null);
        $sum = 0;
        foreach ($data as $item) {
            foreach ($item['input'] as $signal) {
                switch (count($signal)) {
                    case 2: // 1
                        $one = $signal;
                        break;
                    case 3: // 7
                        $seven = $signal;
                        break;
                    case 4: // 4
                        $four = $signal;
                        break;
                    case 7: // 8
                        $eight = $signal;
                        break;
                }
            }

            foreach ($item['input'] as $signal) {
                switch (count($signal)) {
                    case 5:
                        if (count(array_intersect($one, $signal)) == 2) {
                            $three = $signal;
                        }
                        break;
                    case 6:
                        if (count(array_intersect($one, $signal)) != 2) {
                            $six = $signal;
                        }
                        break;
                }
            }

            $mapping['a'] = current(array_diff($seven, $one));
            $mapping['c'] = current(array_diff($one, $six));
            $mapping['f'] = current(array_diff($one, [$mapping['c']]));
            $mapping['g'] = array_reduce($three, function ($c, $v) use ($four, $seven) {
                return (in_array($v, array_merge($four, $seven))) ? $c : $v;
            }, '');

            $mapping['d'] = current(array_diff($three, array_merge($seven, [$mapping['g']])));
            $mapping['b'] = current(array_diff($four, array_merge($one, [$mapping['d']])));
            $mapping['e'] = current(array_diff($eight, array_merge($three, $four)));

            $rMapping = array_flip($mapping);

            $decoded = [];
            $decodedValue = '';
            foreach ($item['output'] as $signal) {
                $value = array_reduce($signal, function ($c, $v) use ($rMapping) {
                    $c[] = $rMapping[$v];
                    return $c;
                }, []);

                sort($value);
                $decodedValue .= $rDisplay[implode($value)];
            }
            //echo $decodedValue . PHP_EOL;
            $sum += (int) $decodedValue;
        }

        return $sum;
    }
}
