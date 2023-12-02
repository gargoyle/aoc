<?php

namespace Year2022\Day07;

interface iFilesystemItem
{
    public function listText(): string;
    public function size(): int;
}
