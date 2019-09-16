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

    /**
     * @see https://www.youtube.com/watch?v=M8BYckxI8_U
     *
     * in a n*n sized grid, a path from one edge to another will take 2*n steps.
     * the path can only contain size-times right and size-times down moves.
     * so we have to calculate the permutations.
     */
    public function run() : string
    {
        $size = 20;

        $factorials = [
            0 => 1,
        ];

        for ($i = 1; $size * 2 >= $i; ++$i) {
            $factorials[$i] = $factorials[$i - 1] * $i;
        }

        $pathCount = $factorials[$size * 2] / ($factorials[$size] * $factorials[$size]);

        return "{$pathCount}";
    }
}
