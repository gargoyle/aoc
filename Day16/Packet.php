<?php

namespace Day16;

class Packet extends \stdClass
{
    public function value()
    {
        switch ($this->type) {
            case 4: return $this->payload;
            case 0: return $this->sum();
            case 1: return $this->product();
            case 2: return $this->min();
            case 3: return $this->max();
            case 5: return $this->gt();
            case 6: return $this->lt();
            case 7: return $this->et();
        }
    }

    public function gt()
    {
        return ($this->payload[0]->value() > $this->payload[1]->value()) ? 1 : 0;
    }


    public function lt()
    {
        return ($this->payload[0]->value() < $this->payload[1]->value()) ? 1 : 0;
    }


    public function et()
    {
        return ($this->payload[0]->value() == $this->payload[1]->value()) ? 1 : 0;
    }

    public function sum()
    {
        if (!is_array($this->payload)) {
            return 0;
        }

        $sum = 0;
        foreach ($this->payload as $packet) {
            $sum += $packet->value();
        }

        return $sum;
    }

    public function product()
    {
        if (!is_array($this->payload)) {
            return 0;
        }

        $product = 1;
        foreach ($this->payload as $packet) {
            $product *= $packet->value();
        }

        return $product;
    }

    public function min()
    {
        if (!is_array($this->payload)) {
            return 0;
        }

        $min = PHP_INT_MAX;
        foreach ($this->payload as $packet) {
            if ($packet->value() < $min) {
                $min = $packet->value();
            }
        }

        return $min;
    }

    public function max()
    {
        if (!is_array($this->payload)) {
            return 0;
        }

        $max = 0;
        foreach ($this->payload as $packet) {
            if ($packet->value() > $max) {
                $max = $packet->value();
            }
        }

        return $max;
    }
}
