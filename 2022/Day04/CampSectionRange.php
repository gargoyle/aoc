<?php

namespace Year2022\Day04;

class CampSectionRange
{
    public function __construct(readonly int $start, readonly int $end)
    {
    }
    
    private function containsSection(int $section): bool
    {
        return ($section >= $this->start) && ($section <= $this->end);
    }
    
    public function overlaps(CampSectionRange $other): bool
    {
        return CampSectionRange::Contains($this, $other) || 
                $this->containsSection($other->start) || 
                ($this->containsSection($other->end));
    }
    
    public static function Contains(
            CampSectionRange $sr1, 
            CampSectionRange $sr2
    ): bool {
        $oneContainsTwo = (
                $sr1->containsSection($sr2->start) && 
                $sr1->containsSection($sr2->end));
        
        $twoContainsOne = (
                $sr2->containsSection($sr1->start) && 
                $sr2->containsSection($sr1->end));
        
        return ($twoContainsOne || $oneContainsTwo);
    }
}
