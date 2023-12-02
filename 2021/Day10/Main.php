<?php

namespace Day10;

class Main extends \Base
{
    private $chunkCodes = [
        '(' => ')',
        '[' => ']',
        '{' => '}',
        '<' => '>',
    ];
    private $errorPoints = [
        ')' => 3,
        ']' => 57,
        '}' => 1197,
        '>' => 25137
    ];
    private $autocompletePoints = [
        ')' => 1,
        ']' => 2,
        '}' => 3,
        '>' => 4
    ];

    public function title(): string
    {
        return "Syntax Scoring";
    }

    public function one(): string
    {
        $openers = array_keys($this->chunkCodes);
        $closers = array_values($this->chunkCodes);

        $score = 0;
        foreach ($this->lines as $row) {
            $stack = new \SplStack();

            for ($i = 0; $i < strlen($row); $i++) {
                $code = $row[$i];
                if (in_array($code, $openers)) {
                    $stack->push($code);
                } else {
                    if ($stack->isEmpty()) {
                        // Invalid, expecting an opener.
                        $score += $this->errorPoints[$code];
                        break;
                    }

                    if ($code == $this->chunkCodes[$stack->top()]) {
                        // valid closing code, pop the stack.
                        $stack->pop();
                    } else {
                        // Invalid, line is corrupted.
                        $score += $this->errorPoints[$code];
                        break;
                    }
                }
            }
        }
        return (string)$score;
    }

    public function two(): string
    {
        $openers = array_keys($this->chunkCodes);
        $closers = array_values($this->chunkCodes);

        $autocompleteScores = [];
        foreach ($this->lines as $row) {
            $stack = new \SplStack();
            $corrupted = false;

            for ($i = 0; $i < strlen($row); $i++) {
                $code = $row[$i];
                if (in_array($code, $openers)) {
                    $stack->push($code);
                } else {
                    if ($stack->isEmpty()) {
                        // Corrupted line, ignore.
                        $corrupted = true;
                        break;
                    }

                    if ($code == $this->chunkCodes[$stack->top()]) {
                        // valid closing code, pop the stack.
                        $stack->pop();
                    } else {
                        // Corrupted line, ignore.
                        $corrupted = true;
                        break;
                    }
                }
            }

            if ($corrupted) {
                continue;
            }

            // End of line, pop the remaining stack and find all the closing chars.
            $closing = '';
            while (!$stack->isEmpty()) {
                $closing .= $this->chunkCodes[$stack->pop()];
            }

            // Score the closing line.
            $as = 0;
            foreach (str_split($closing) as $char) {
                $as = ($as * 5) + $this->autocompletePoints[$char];
            }
            $autocompleteScores[] = $as;
        }

        sort($autocompleteScores);
        $midIndex = floor(count($autocompleteScores) / 2);

        return (string)$autocompleteScores[$midIndex];
    }
}
