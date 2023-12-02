<?php

namespace Year2022\Day03;

class Rucksack
{

    private static string $types = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public function __construct(
            readonly array $compartmentA, 
            readonly array $compartmentB)
    {
    }

    private function combinedContents(): array
    {
        return array_merge($this->compartmentA, $this->compartmentB);
    }

    public static function TypePriority(string $itemType): int
    {
        return strpos(self::$types, $itemType) + 1;
    }

    public function commonItemType(): string
    {
        $itemType = array_values(array_intersect(
                                $this->compartmentA,
                                $this->compartmentB
                                ))[0];

        return $itemType;
    }

    public function commonItemTypeWithOtherRucksacks(Rucksack $r1, Rucksack $r2): string
    {
        $itemType = array_values(array_intersect(
                                $this->combinedContents(),
                                $r1->combinedContents(),
                                $r2->combinedContents()
                                ))[0];

        return $itemType;
    }

    public static function withContents(string $contents): self
    {
        $aContents = str_split($contents);
        $i = new self(
                array_slice($aContents, 0, strlen($contents) / 2),
                array_slice($aContents, (strlen($contents) / 2)));
        return $i;
    }

}
