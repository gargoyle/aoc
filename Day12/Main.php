<?php

namespace Day12;

class Main extends \Base
{
    private $caves = [];
    
    public function title(): string {
        return "Passage Pathing";
    }

    public function one(): string {
        
        foreach ($this->lines as $line) {
            list($label1, $label2) = explode('-', $line);
            if (!isset($this->caves[$label1])) {
                $this->caves[$label1] = new Cave($label1);
            }
            if (!isset($this->caves[$label2])) {
                $this->caves[$label2] = new Cave($label2);
            }
            $this->caves[$label1]->linkTo($this->caves[$label2]);
        }
        
        $routes = [];
        $this->caves['start']->visit([], $routes);
//        print_r($routes);
//        foreach ($routes as $route) {
//            printf("%s\n", $route);
//        }
//        echo PHP_EOL;
        
        return count($routes);
    }

    public function two(): string {
        foreach ($this->lines as $line) {
            list($label1, $label2) = explode('-', $line);
            if (!isset($this->caves[$label1])) {
                $this->caves[$label1] = new Cave($label1);
            }
            if (!isset($this->caves[$label2])) {
                $this->caves[$label2] = new Cave($label2);
            }
            $this->caves[$label1]->linkTo($this->caves[$label2]);
        }
        
        $routes = [];
        $this->caves['start']->visit([], $routes, true);
        return count($routes);
    }

}