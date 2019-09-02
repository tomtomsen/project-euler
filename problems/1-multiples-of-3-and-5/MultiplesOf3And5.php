<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems;

use tomtomsen\ProjectEuler\Problem;

final class MultiplesOf3And5 implements Problem
{
    public const MAX = 1000;

    public function number() : int
    {
        return 1;
    }

    public function name() : string
    {
        return 'Multiple of 3 and 5';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            If we list all the natural numbers below 10 that are multiples of 3 or 5, we get 3, 5, 6 and 9. The sum of these multiples is 23.
            Find the sum of all the multiples of 3 or 5 below 1000.
            DESCRIPTION;
    }

    public function run() : string
    {
        $sum = 0;

        for ($i = 3; self::MAX > $i; $i += 3) {
            $sum += $i;
        }

        for ($i = 5; self::MAX > $i; $i += 5) {
            $sum += $i;
        }

        for ($i = 15; self::MAX > $i; $i += 15) {
            $sum -= $i;
        }

        return "{$sum}";
    }
}
