<?php

namespace Year2022\Day07;

class File implements iFilesystemItem
{
    public function __construct(readonly int $size, readonly string $name)
    {
    }
    
    public function listText(): string
    {
        return sprintf("%s (file, size=%s)", $this->name, $this->size);
    }

    public function size(): int
    {
        return $this->size;
    }

}
