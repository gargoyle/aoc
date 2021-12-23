<?php

namespace Day20;

class RawImage
{
    private string $algo;
    private $lines;

    public function __construct(array $lines, string $algo)
    {
        $this->lines = $lines;
        $this->algo = $algo;
    }

    public function getEnhancedLines()
    {
        $lines = [];
        for ($y = -2; $y < $this->getHeight()+2; $y++) {
            $line = '';
            for ($x = -2; $x < $this->getWidth()+2; $x++) {
                $line .= $this->getEnhancedPixel($x, $y);
            }
            $lines[] = $line;
        }
        return $lines;
    }

    public function getPixel($x, $y)
    {
        $oobX = ($x < 0) || ($x >= count($this->lines));
        $oobY = ($y < 0) || ($y >= count($this->lines));

        if ($oobX || $oobY) {
            return ".";
        } else {
            return $this->lines[$y][$x];
        }
    }

    public function getEnhancedPixel($x, $y)
    {
        $areaVal = $this->getAreaValue($x, $y);
        $enhancedPixel = $this->algo[$areaVal];
        return $enhancedPixel;
    }

    public function getArea($x, $y)
    {
        $area = '';
        for ($i = $y-1; $i <= $y+1; $i++) {
            for ($z = $x-1; $z <= $x+1; $z++) {
                $area .= $this->getPixel($z, $i);
            }
        }
        return $area;
    }

    public function getAreaValue($x, $y)
    {
        $area = $this->getArea($x, $y);
        $area = str_replace([".", "#"], [0, 1], $area);

        return bindec($area);
    }

    public function getLitCount()
    {
        $litCount = 0;

        for ($y = 0; $y < $this->getHeight(); $y++) {
            for ($x = 0; $x < $this->getWidth(); $x++) {
                if ($this->getPixel($x, $y) == "#") {
                    $litCount++;
                }
            }
        }

        return $litCount;
    }

    public function getWidth()
    {
        return strlen($this->lines[0]);
    }

    public function getHeight()
    {
        return count($this->lines);
    }
}
