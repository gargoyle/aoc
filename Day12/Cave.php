<?php

namespace Day12;

class Cave
{
    private string $label;
    
    private array $linksTo;
    
    private bool $multi = false;
    
    private int $visitCount = 0;
    
    public function isMulti(): bool
    {
        return $this->multi;
    }
   
    public function __construct(string $label)
    {
        $this->label = $label;
        $this->linksTo = [];
        if ($label === strtoupper($label)) {
            $this->multi = true;
        }
    }

    public function linkTo(Cave $other, bool $linkBack = true)
    {
        $this->linksTo[$other->label] = $other;
        if ($linkBack) {
            $other->linkTo($this, false);
        }
    }
    
    public function label(): string
    {
        return $this->label;
    }
    
    public function canVisit($smallCaveLimit = 1): bool {
        if ($this->label == "start") {
            return false;
        }
        
        if ($this->label == "end") {
            $smallCaveLimit = 1;
        }
        
        if ($this->isMulti() || $this->visitCount < $smallCaveLimit) {
            return true;
        }
        
        return false;
    }

    public function visit()
    {
        $routes = [];
        $routes[] = $this->label;
        $this->visitCount++;
        
        foreach ($this->linksTo as $cave) {
            if ($cave->canVisit()) {
                $routes[] = array_merge($routes, $cave->visit());
            }
        }
        
        return $routes;
    }

}
