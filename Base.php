<?php

abstract class Base 
{
    protected $lines = [];
    
    public function __construct(&$lines) {
        $this->lines = $lines;
    }
    
    abstract public function title(): string;
    abstract public function one(): string;
    abstract public function two(): string;
}
