<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem29;

use Brick\Math\BigInteger;
use tomtomsen\ProjectEuler\Problem;

final class DistinctPowers implements Problem
{
    public const MAX_A = 100;
    public const MAX_B = 100;
    public const MIN_A = 2;
    public const MIN_B = 2;

    public function number() : int
    {
        return 29;
    }

    public function name() : string
    {
        return 'Distinct powers';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            Consider all integer combinations of ab for 2 ≤ a ≤ 5 and 2 ≤ b ≤ 5:
            22=4, 23=8, 24=16, 25=32
            32=9, 33=27, 34=81, 35=243
            42=16, 43=64, 44=256, 45=1024
            52=25, 53=125, 54=625, 55=3125
            If they are then placed in numerical order, with any repeats removed, we get the following sequence of 15 distinct terms:
            4, 8, 9, 16, 25, 27, 32, 64, 81, 125, 243, 256, 625, 1024, 3125
            How many distinct terms are in the sequence generated by ab for 2 ≤ a ≤ 100 and 2 ≤ b ≤ 100?
            DESCRIPTION;
    }

    public function run() : string
    {
        $numbers = [];

        for ($a = self::MIN_A; self::MAX_A >= $a; ++$a) {
            for ($b = self::MIN_B; self::MAX_B >= $b; ++$b) {
                $x = BigInteger::of("{$a}")->power($b);
                $numbers[(string) $x] = true;
            }
        }

        $count = \count($numbers);

        return "{$count}";
    }
}
