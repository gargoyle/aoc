<?php

namespace Day04;

/**
 * Represents a single square on the grid and keeps track
 * if it is marked or not.
 *
 * 26 15 50 56  2
 * 20 27 42 11 16
 * 93 44 38 28 68
 * 66 88 78 81 77
 * 91 46 55 86  6
 */
class Square
{
    private const UNMARKED_COLOR = "0;30";
    private const MARKED_COLOR = "0;32";

    private bool $marked;
    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
        $this->marked = false;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function isMarked(): bool
    {
        return $this->marked;
    }

    public function mark(int $value): void
    {
        if ($this->value == $value) {
            $this->marked = true;
        }
    }

    public function __toString()
    {
        return sprintf(
            "\e[%sm%2s\e[0m",
            $this->marked ? self::MARKED_COLOR : self::UNMARKED_COLOR,
            $this->value
        );
    }
}
