<?php

namespace Year2022\Lib;

class ColumnReader
{
    private array $data = [];
    
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function readColumn(int $pos): array
    {
        $column = [];
        foreach ($this->data as $line) {
            if ($pos < strlen($line)) {
                $column[] = $line[$pos];
            }
        }
        return $column;
    }
    
    public function numColumns(): int
    {
        $longest = 0;
        foreach ($this->data as $line) {
            if (strlen($line) > $longest) {
                $longest = strlen($line);
            }
        }
        return $longest;
    }
}
