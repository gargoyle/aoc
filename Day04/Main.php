<?php

namespace Day04;

class Main extends \Base
{
    private ?Card $first = null;
    private ?Card $last = null;

    public function title(): string
    {
        return "Giant Squid";
    }

    public function one(): string
    {
        $loader = new DataLoader($this->lines);

        $callSequence = $loader->callSequence();
        $cards = $loader->cards();

        printf(
            "Loaded %s caller values and %d cards\n",
            count($callSequence),
            count($cards)
        );

        $game = new Bingo($callSequence, $cards);
        list($this->first, $this->last) = $game->play();

        return $this->first->score();
    }

    public function two(): string
    {
        return $this->last->score();
    }
}
