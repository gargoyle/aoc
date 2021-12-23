<?php

namespace Day12;

class Cave
{
    private string $label;

    private array $linksTo;

    private bool $large = false;

    public function isLarge(): bool
    {
        return $this->large;
    }

    public function __construct(string $label)
    {
        $this->label = $label;
        $this->linksTo = [];
        if ($label === strtoupper($label)) {
            $this->large = true;
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

    public function canVisit(array $currentPath, $alt = false): bool
    {
        // Large caves can be visited any number of times.
        if ($this->isLarge()) {
            return true;
        }

        // start cave can never be visited again.
        if ($this->label == "start") {
            return false;
        }

        // small caves can be visited if they have not already been visited.
        if (!in_array($this->label, $currentPath)) {
            return true;
        }

        // Below this line we are evaluating a second visit to a small cave...

        // End cave can only be visited once.
        if ($this->label == "end") {
            return false;
        }

        // If we're in alt mode, a single small cave can be re-visited.
        if ($alt) {
            // allow 1 second visit to a small cave.
            $numVisits = array_count_values($currentPath);
            $allowSecondSmallVisit = true;
            foreach ($numVisits as $label => $count) {
                if ($label == strtoupper($label)) {
                    continue;
                }
                if (in_array($label, ['start','end'])) {
                    continue;
                }
                if ($count > 1) {
                    $allowSecondSmallVisit = false;
                }
            }

            return $allowSecondSmallVisit;
        }

        return false;
    }

    public function visit($currentPath, &$routes, $alt = false)
    {
        $currentPath[] = $this->label;

        if ($this->label == "end") {
            $routes[] = implode(",", $currentPath);
            return;
        }

        foreach ($this->linksTo as $cave) {
            if ($cave->canVisit($currentPath, $alt)) {
                $cave->visit($currentPath, $routes, $alt);
            }
        }
    }
}
