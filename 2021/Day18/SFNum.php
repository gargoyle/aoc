<?php

namespace Day18;

class SFNum
{
    private ?SFNum $parent = null;

    private $right = null;
    private $left = null;
    private $value = null;

    public static function createNested(SFNum $left, SFNum $right)
    {
        $instance = new SFNum(0);
        $left->parent = $instance;
        $right->parent = $instance;

        $instance->left = $left;
        $instance->right = $right;
        $instance->value = null;

        return $instance;
    }

    public function __construct($val, SFNum $parent = null)
    {
        if (is_array($val) && (count($val) == 2)) {
            $this->left = new SFNum($val[0], $this);
            $this->right = new SFNum($val[1], $this);
        } else {
            $this->value = (int)$val;
        }

        if ($parent !== null) {
            $this->parent = $parent;
        }
    }

    public function magnitude()
    {
        if ($this->isValue()) {
            return $this->value;
        } else {
            return (3 * $this->left->magnitude()) + (2 * $this->right->magnitude());
        }
    }

    public function reduce()
    {
        while (true) {
            $didExplode = $this->explodeIfNeeded();
            if (!$didExplode) {
                $didSplit = $this->splitIfNeeded();
            }

            if (!$didExplode && !$didSplit) {
                break;
            }
        }
    }

    public function isValue(): bool
    {
        return ($this->value !== null);
    }

    public function __toString()
    {
        if ($this->isValue()) {
            return $this->value;
        } else {
            return sprintf("[%s,%s]", $this->left, $this->right);
        }
    }

    public function depth(): int
    {
        if ($this->parent !== null) {
            return $this->parent->depth() + 1;
        } else {
            return 1;
        }
    }

    public function splitIfNeeded(): bool
    {
        if ($this->isValue()) {
            if ($this->value >= 10) {
                //printf("\tSplitting %s\n", $this->value);
                $this->left = new SFNum(floor($this->value/2), $this);
                $this->right = new SFNum(ceil($this->value/2), $this);
                $this->value = null;

                //$this->explodeIfNeeded();
                return true;
            }
            return false;
        } else {
            return ($this->left->splitIfNeeded() || $this->right->splitIfNeeded());
        }
    }

    public function explodeIfNeeded(): bool
    {
        //printf("Depth: %s, value=%s\n", $this->depth(), $this);

        if (($this->depth() == 5) && (!$this->isValue())) {
            $origLeft = $this->left->value;
            $origRight = $this->right->value;
            $this->value = 0;
            $this->left = null;
            $this->right = null;

            //printf("\tExploding [%s,%s]\n", $origLeft, $origRight);

            $this->parent->notifyExplosionLeftValue($this, $origLeft);
            $this->parent->notifyExplosionRightValue($this, $origRight);
            return true;
        } elseif (!$this->isValue()) {
            return ($this->left->explodeIfNeeded() || $this->right->explodeIfNeeded());
        } else {
            return false;
        }
    }

    public function notifyExplosionLeftValue($child, $value): void
    {
        if (spl_object_hash($child) == spl_object_hash($this->left)) {
            // exploded child was on my left side, pass notification up.
            if ($this->parent !== null) {
                $this->parent->notifyExplosionLeftValue($this, $value);
            }
        } else {
            // child was on my right, walk back down the tree until we can add the value to a right number.
            $this->left->addRightMostValue($value);
        }
    }

    public function notifyExplosionRightValue($child, $value): void
    {
        if (spl_object_hash($child) == spl_object_hash($this->right)) {
            // exploded child was on my right side, pass notification up.
            if ($this->parent !== null) {
                $this->parent->notifyExplosionRightValue($this, $value);
            }
        } else {
            // child was on my left, walk back down the tree until we can add the value to a left number.
            $this->right->addLeftMostValue($value);
        }
    }

    public function addRightMostValue($value)
    {
        if ($this->isValue()) {
            $this->value += (int)$value;
        } else {
            $this->right->addRightMostValue($value);
        }
    }

    public function addLeftMostValue($value)
    {
        if ($this->isValue()) {
            $this->value += (int)$value;
        } else {
            $this->left->addLeftMostValue($value);
        }
    }
}
