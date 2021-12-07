<?php

/**
 * Represents a single bingo card which is initialised 
 * with a 5x5 2d array of rows and columns.
 * 
 * 26 15 50 56  2
 * 20 27 42 11 16
 * 93 44 38 28 68
 * 66 88 78 81 77
 * 91 46 55 86  6
 */
class Card {

    private int $id;

    const ROWS = 5;
    const COLS = 5;
    
    private array $squares;
    private ?int $winningCall;
    
    public function __construct(array $data, int $id = 0) {
        $this->id = $id;
        $this->squares = [];
        $this->winningCall = null;
        $this->loadData($data);
    }

    public function getId(): int
    {
        return $this->id;
    }

    private function loadData(array $data): void {
        for ($row = 0; $row < self::ROWS; $row++) {
            for ($col = 0; $col < self::COLS; $col++) {
                if (!isset($data[$row]) || !isset($data[$row][$col])) {
                    throw new InvalidArgumentException(sprintf(
                            "Bad card data. row %d, col %d is missing!",
                            $row, $col));
                }
                
                $this->squares[$row][$col] = new Square($data[$row][$col]);
            }
        }
    }
    
    public function mark(int $value): void {
        if ($this->hasWon()) {
            return;
        }
        
        for ($row = 0; $row < self::ROWS; $row++) {
            for ($col = 0; $col < self::COLS; $col++) {
                $this->squares[$row][$col]->mark($value);
            }
        }
        
        if ($this->hasWon() && ($this->winningCall == null)) {
            $this->winningCall = $value;
        }
    }
    
    public function hasWon(): bool
    {
        $rowMarks = [];
        $colMarks = [];
        for ($row = 0; $row < self::ROWS; $row++) {
            for ($col = 0; $col < self::COLS; $col++) {
                if ($this->squares[$row][$col]->isMarked()) {
                    isset($rowMarks[$row]) ? $rowMarks[$row]++ : $rowMarks[$row] = 1;
                    isset($colMarks[$col]) ? $colMarks[$col]++ : $colMarks[$col] = 1;
                    
                    if ($rowMarks[$row] == self::COLS) { return true; }
                    if ($colMarks[$col] == self::ROWS) { return true; }
                }
            }
        }
        
        return false;
    }
    
    public function score(): int {
        if (!$this->hasWon()) {
            return 0;
        }
        
        $score = 0;
        for ($row = 0; $row < self::ROWS; $row++) {
            for ($col = 0; $col < self::COLS; $col++) {
                if (!$this->squares[$row][$col]->isMarked()) {
                    $score += $this->squares[$row][$col]->value();
                }
            }
        }
        
        return $score * $this->winningCall;
    }
    
    public function __toString() {
        $output = '';
        
        for ($row = 0; $row < self::ROWS; $row++) {
            for ($col = 0; $col < self::COLS; $col++) {
                $output .= $this->squares[$row][$col] . " ";
            }
            $output .= "\n";
        }
        $output .= "Score: " . $this->score() . "\n";
        $output .= "Winning call: " . $this->winningCall . "\n\n";
        
        return $output;
    }
}
