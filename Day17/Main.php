<?php

namespace Day17;

class Main extends \Base
{
    private const BASE_COLOR = "0;30";
    private const SHIP_COLOR = "0;33";
    private const PROBE_COLOR = "0;31";
    private const TARGET_COLOR = "0;34";
    
    public function title(): string {
        return "Trick Shot";
    }

    private function target(): array
    {
        if (TEST_MODE) {
            return [20, 30, -10, -5];
        } else {
            return [175, 227, -134, -79];
        }
    }
    
    public function one(): string {
        // Max y velocity = target offset distance + target heigh
        list ($tx1, $tx2, $ty1, $ty2) = $this->target();
        $minX = 0;
        $dist = 0;
        while ($dist < $tx1) {
            $minX++;
            $dist = ($minX * ($minX + 1))/2;
        }
        $maxY = (abs(0 - $ty2) + abs($ty1 - $ty2)) - 1;
        
        echo $maxY . "\n";
        echo $minX . "\n";
        
        $p = new Probe($minX, $maxY);
        for ($i = 0; $i < 500; $i++) {
            $p->tick();

            $inZoneY = ($p->y >= $ty1) && ($p->y <= $ty2);
            $inZoneX = ($p->x >= $tx1) && ($p->x <= $tx2);

            echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
            for ($y = 45; $y >= $ty1-1; $y--) {
                for ($x = 0; $x < 32; $x++) {
                    $r_inZoneY = ($y >= $ty1) && ($y <= $ty2);
                    $r_inZoneX = ($x >= $tx1) && ($x <= $tx2);
                    
                    if (($x == $p->x) && ($y == $p->y)) {
                        $char = "o ";
                        $color = self::PROBE_COLOR;
                    } else {
                        if ($r_inZoneX && $r_inZoneY) {
                            $char = "x ";
                            $color = self::TARGET_COLOR;
                        } else {
                            if ($y != 0) {
                                $char = ". ";
                                $color = self::BASE_COLOR;
                            } else {
                                if ($x == 0) {
                                    $char = "//";
                                    $color = self::SHIP_COLOR;
                                } else {
                                    $char = "--";
                                    $color = self::BASE_COLOR;
                                }
                            }
                        }
                    }
                    
                    printf("\e[%sm%2s\e[0m", $color, $char);
                }
                echo "\n";
            }
            usleep(100*1000);
            
            if ($inZoneX && $inZoneY) {
                break;
            }
        }
        
        return $p->maxAlt;
    }

    public function two(): string {
        
        list ($tx1, $tx2, $ty1, $ty2) = $this->target();
        $maxY = (abs(0 - $ty2) + abs($ty1 - $ty2)) - 1;
        
        $hits = 0;
        for ($x = 0; $x < 228; $x++) {
            for ($y = -134; $y <= $maxY; $y++) {
                $p = new Probe($x, $y);
                
                for ($i = 0; $i < 500; $i++) {
                    $p->tick();

                    $inZoneY = ($p->y >= $ty1) && ($p->y <= $ty2);
                    $inZoneX = ($p->x >= $tx1) && ($p->x <= $tx2);

                    if ($inZoneX && $inZoneY) {
//                        echo "$x:$y => " . $p->status();
                        $hits++;
                        break;
                    }
                }
            }
        }

        return $hits;
    }
}