<?php

namespace Year2022\Day07;

use SplStack;

class Filesystem
{
    const CAPACITY = 70000000;
    
    private Directory $root;
    private SplStack $cwd;
    
    public function __construct(array $input)
    {
        $this->root = new Directory('/');
        $this->cwd = new SplStack();
        $this->cwd->push($this->root);
        
        foreach ($input as $line) {
            $parts = explode(' ', $line);
            switch ($parts[0]) {
                case '$': $this->exec($parts); break;
                case 'dir': $this->createDirectory($parts[1]); break;
                default: $this->addFile($parts[0], $parts[1]); break;
            }
        }
    }
    
    public function freeSpace(): int
    {
        return self::CAPACITY - $this->root->size();
    }
    
    private function exec(array $cmd): void
    {
        switch ($cmd[1]) {
            case 'cd': $this->changeDirectory($cmd[2]); break;
            case 'ls': break;
            default: break;
        }
    }
    
    private function changeDirectory(string $target): void
    {
        if ($target == '/') {
            $this->cwd = new SplStack();
            $this->cwd->push($this->root);
        } elseif ($target == '..') {
            if ($this->cwd->count() > 1) {
                $this->cwd->pop();
            }
        } else {
            $item = $this->cwd->top()->getItem($target);
            if (!$item instanceof Directory) {
                die('Invalid directory');
            }
            $this->cwd->push($item);
        }
    }
    
    private function createDirectory(string $name): void
    {
        if ($this->cwd->top()->getItem($name) !== null) {
            // already exists.
            return;
        }
        
        $this->cwd->top()->addItem(new Directory($name));
    }
    
    private function addFile(int $size, string $name): void
    {
        $this->cwd->top()->addItem(new File($size, $name));
    }
    
    public function flat(): \Generator
    {
        $rit = new \RecursiveIteratorIterator(
                $this->root, 
                \RecursiveIteratorIterator::SELF_FIRST);
        
        foreach ($rit as $item) {
            yield $item;
        }
    }
}
