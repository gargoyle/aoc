<?php

namespace Day23;

class Wall extends Tile
{
    private const COLOR = "0;33";

    public function __toString()
    {
        return sprintf("\e[%sm%s\e[0m", self::COLOR, "###");
    }
}
