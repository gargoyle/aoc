<?php

namespace Day23;

class EmptySpace extends Tile
{
    private const COLOR = "0;30";

    public function __toString()
    {
        return sprintf("\e[%sm%s\e[0m", self::COLOR, " . ");
    }
}
