<?php

namespace Day20;

class Main extends \Base
{
    private $ea;

    public function title(): string
    {
        return "Trench Map";
    }

    public function __construct(&$lines)
    {
        parent::__construct($lines);
        $this->ea = array_shift($this->lines);
        array_shift($this->lines); // discard blank line.
    }

    public function one(): string
    {
        $rawImage = new RawImage($this->lines, $this->ea);

        for ($i = 0; $i < 2; $i++) {
            $enhancedLines = $rawImage->getEnhancedLines();
            $rawImage = new RawImage($enhancedLines, $this->ea);
        }

        return $rawImage->getLitCount() . " [This is wrong, I messed up my algo during code cleanup :( ]";
    }

    public function two(): string
    {
        $rawImage = new RawImage($this->lines, $this->ea);

        for ($i = 0; $i < 50; $i++) {
            $enhancedLines = $rawImage->getEnhancedLines();
            $rawImage = new RawImage($enhancedLines, $this->ea);
        }

        return $rawImage->getLitCount() . " [This is wrong, I messed up my algo during code cleanup :( ]";
    }
}
