<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem28;

use tomtomsen\ProjectEuler\Problem;

final class NumberSpiralDiagonals implements Problem
{
    public const SIZE = 1001;

    public function number() : int
    {
        return 28;
    }

    public function name() : string
    {
        return 'Number spiral diagonals';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            Starting with the number 1 and moving to the right in a clockwise direction a 5 by 5 spiral is formed as follows:
            21 22 23 24 25
            20  7  8  9 10
            19  6  1  2 11
            18  5  4  3 12
            17 16 15 14 13
            It can be verified that the sum of the numbers on the diagonals is 101.
            What is the sum of the numbers on the diagonals in a 1001 by 1001 spiral formed in the same way?
            DESCRIPTION;
    }

    public function run() : string
    {
        $n = 1;
        $x = 1;

        for ($j = 2; self::SIZE > $j; $j += 2) {
            for ($i = 0; 4 > $i; ++$i) {
                $x += $j;
                $n += $x;
            }
        }

        return "{$n}";
    }
}
