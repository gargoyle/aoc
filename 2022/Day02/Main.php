<?php

namespace Year2022\Day02;

use Year2022\Lib\InputReader;

class Main
{
    const LOSS_SCORE = 0;
    const DRAW_SCORE = 3;
    const WIN_SCORE = 6;
 
    private static $shapeScores = [
            'ROCK' => 1,
            'PAPER' => 2,
            'SCISSORS' => 3    
    ];
    
    public static function Title(): string
    {
        return "Rock Paper Scissors";
    }
    
    private static function roundScore($them, $us): int
    {
        $score = match (true) {
            ($them == $us) => self::DRAW_SCORE,
            (($them == 'ROCK') && ($us == 'PAPER')) => self::WIN_SCORE ,
            (($them == 'PAPER') && ($us == 'SCISSORS')) => self::WIN_SCORE,
            (($them == 'SCISSORS') && ($us == 'ROCK')) => self::WIN_SCORE,
            default => self::LOSS_SCORE
        };
        
        $score += self::$shapeScores[$us];
        
        return $score;
    }
    
    private static function shapeFor($them, $reqOutcome): string
    {
        if ($reqOutcome == 'DRAW') {
            return $them;
        }
        
        return match ($them . "_" . $reqOutcome) {
            'ROCK_WIN' => 'PAPER',
            'ROCK_LOSE' => 'SCISSORS',
            'PAPER_WIN' => 'SCISSORS',
            'PAPER_LOSE' => 'ROCK',
            'SCISSORS_WIN' => 'ROCK',
            'SCISSORS_LOSE' => 'PAPER'
        };
    }

    public static function TaskOne(): string
    {
        $total = 0;
        
        $key = [
            'A' => 'ROCK',
            'B' => 'PAPER',
            'C' => 'SCISSORS',
            'X' => 'ROCK',
            'Y' => 'PAPER',
            'Z' => 'SCISSORS',
        ];
        
        foreach (InputReader::cleanedLines(__DIR__) as $line) {
            list ($them, $us) = explode(' ', $line, 2);
            $them = $key[$them];
            $us = $key[$us];
            
            $total += self::roundScore($them, $us);
        }
        
        return $total;
    }
    
    public static function TaskTwo(): string
    {
        $total = 0;
        
        $themKey = [
            'A' => 'ROCK',
            'B' => 'PAPER',
            'C' => 'SCISSORS'
        ];
        
        $outcomeKey = [
            'X' => 'LOSE',
            'Y' => 'DRAW',
            'Z' => 'WIN',
        ];
        
        foreach (InputReader::cleanedLines(__DIR__) as $line) {
            list ($them, $outcome) = explode(' ', $line, 2);
            $them = $themKey[$them];
            $us = self::shapeFor($them, $outcomeKey[$outcome]);
            
            $total += self::roundScore($them, $us);
        }
        
        return $total;
    }
}
