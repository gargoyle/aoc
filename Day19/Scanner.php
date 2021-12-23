<?php

namespace Day19;

class Scanner
{
    private $beacons;

    public function __construct()
    {
        $this->beacons = [];
    }

    public function addBeacon($x, $y, $z)
    {
        $this->beacons[] = [$x, $y, $z];
    }
}
