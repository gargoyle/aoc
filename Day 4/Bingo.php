<?php

/**
 * A nice game of submarine bingo!
 */
class Bingo {

    private array $callSequence;
    private array $cards;
    
    private ?Card $firstWinningCard = null;
    private ?Card $lastWinningCard = null;
        
    public function __construct(array $callSequence, array $cards) {
        $this->callSequence = $callSequence;
        $this->cards = $cards;
        
        $this->winningCardIndex = null;
        
    }

    private function allCardsWon(): bool {
        foreach ($this->cards as $card) {
            if (!$card->hasWon()) {
                return false;
            }
        }
        return true;
    }
    
    public function play()
    {
        
        
        foreach ($this->callSequence as $round => $value) {
        
            //printf("Round %s", $round);
            $this->call($value);
            usleep(170000);
            echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
                    echo $this->cards[68];
                    echo $this->cards[81];
        }
        
        echo "\n";
        echo " !! Game complete !! \n";
//        
//        echo "First winning card was: \n";
//        echo $this->firstWinningCard;
//        
//        echo "Last Winning card was: \n";
//        echo $this->lastWinningCard;        
    }

    private function call(int $value): void
    {
        //printf("Caller: %s\n", $value);
        for ($i = 0; $i < count($this->cards); $i++) {
            $card = $this->cards[$i];
            
            /** @var Card $card */
            $card->mark($value);
            
            if ($card->hasWon()) {
                if ($this->firstWinningCard == null) {
                    $this->firstWinningCard = $card;
                    //echo "Card " . $i . " HOUSE (1st)";
                }

                if ($this->allCardsWon() && ($this->lastWinningCard == null)) {
                    $this->lastWinningCard = $card;
                    //echo "Card " . $i . " HOUSE (last)";
                }
            }
        }
    }
}
