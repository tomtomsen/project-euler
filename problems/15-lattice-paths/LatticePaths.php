<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem15;

use tomtomsen\ProjectEuler\Problem;

final class LatticePaths implements Problem
{
    public function number() : int
    {
        return 15;
    }

    public function name() : string
    {
        return 'Lattice paths';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            Starting in the top left corner of a 2×2 grid, and only being able to move to the right and down, there are exactly 6 routes to the bottom right corner.
            
            How many such routes are there through a 20×20 grid?
            DESCRIPTION;
    }

    public function run() : string
    {
        $s = 0;
        $x = 11;
        $this->x(0, 0, $x, $x, $s);

        return "{$s}";
    }

    private function x($x, $y, $mx, $my, &$s) : void
    {
        if ($x < $mx) {
            $this->x($x + 1, $y, $mx, $my, $s);
        }

        if ($y < $my) {
            $this->x($x, $y + 1, $mx, $my, $s);
        }

        if ($y === $my && $x === $mx) {
            ++$s;
        }
    }
}
