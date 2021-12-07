<?php

/**
 * Loads the data file and returns the caller sequence and cards
 *
 * @author paul
 */
class DataLoader {
    private const DATAFILE = "input.txt";
    
    private array $caller;
    private array $cards;
    
    public function __construct() {
        $this->caller = [];
        $this->cards = [];
        $this->load();
    }
    
    public function callSequence(): array
    {
        return $this->caller;
    }
    
    public function cards(): array
    {
        return $this->cards;
    }


    private function setCaller(string $callSequence): void {
        $numbers = explode(",", $callSequence);
        foreach ($numbers as $number) {
            $this->caller[] = (int)$number;
        }
    }
            
    private function load(): void {
        $inputLines = file(self::DATAFILE);
        
        $this->setCaller(array_shift($inputLines));
        
        $cardBuffer = [];
        foreach ($inputLines as $cardLine) {
            $cardLine = trim($cardLine);
            if (empty($cardLine)) { continue; }
            
            $cardBuffer[] = $cardLine;
            
            if (count($cardBuffer) == Card::ROWS) {
                $this->cards[] = $this->createCard($cardBuffer);
                $cardBuffer = [];
            }
        }
        
        if (!empty($cardBuffer)) {
            throw new RuntimeException("Did not load a clean number of cards. Check input!");
        }
    }

    private function createCard(array $cardBuffer): Card {
        if (count($cardBuffer) !== Card::ROWS) {
            throw new RuntimeException("Card buffer did not contain the correct number of rows.");
        }
        
        $cardData = [];
        for ($row = 0; $row < Card::ROWS; $row++) {
            $numbers = preg_split("/[\s]+/", $cardBuffer[$row]);
            if (count($numbers) !== Card::COLS) {
                throw new RuntimeException("Card buffer did not contain the correct number of columns.");
            }
            
            for ($col = 0; $col < Card::COLS; $col++) {
                $cardData[$row][$col] = (int)$numbers[$col];
            }
        }
        
        return new Card($cardData);
    }

}
