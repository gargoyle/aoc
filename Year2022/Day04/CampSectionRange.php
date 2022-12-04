<?php

namespace Year2022\Day04;

class CampSectionRange
{
    public function __construct(string $range)
    {
        list($start, $end) = explode('-', $range);
    }
}
