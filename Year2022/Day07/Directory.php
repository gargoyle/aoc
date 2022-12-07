<?php

namespace Year2022\Day07;

class Directory implements iFilesystemItem, \RecursiveIterator
{
    private array $contents = [];
    private int $currentPointer = 0;
    
    
    public function __construct(readonly string $name)
    {
    }
    
    public function listText(): string
    {
        return sprintf("%s (dir, size=%s)", $this->name, $this->size());
    }
    
    public function addItem($item)
    {
        $this->contents[$item->name] = $item;
    }
    
    public function getItem(string $name)
    {
        if (!isset($this->contents[$name])) {
            return null;
        }
        
        return $this->contents[$name];
    }

    public function size(): int
    {
        $size = 0;
        
        foreach ($this->contents as $item) {
            $size += $item->size();
        }
        
        return $size;
    }

    public function current(): mixed
    {
        return $this->contents[$this->key()];
    }

    public function getChildren(): ?\RecursiveIterator
    {
        if ($this->current() instanceof Directory) {
            return $this->current();
        }
        
        return null;
    }

    public function hasChildren(): bool
    {
        return ($this->current() instanceof Directory);
    }

    public function key(): mixed
    {
        return array_keys($this->contents)[$this->currentPointer];
    }

    public function next(): void
    {
        $this->currentPointer++;
    }

    public function rewind(): void
    {
        $this->currentPointer = 0;
    }

    public function valid(): bool
    {
        return isset(array_keys($this->contents)[$this->currentPointer]);
    }

}
