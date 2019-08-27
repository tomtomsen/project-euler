<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem4;

use tomtomsen\ProjectEuler\Problem;

final class SumSquareDifference implements Problem
{
    public function number() : int
    {
        return 6;
    }

    public function name() : string
    {
        return 'Sum square difference';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            The sum of the squares of the first ten natural numbers is,
            12 + 22 + ... + 102 = 385
            The square of the sum of the first ten natural numbers is,
            (1 + 2 + ... + 10)2 = 552 = 3025
            Hence the difference between the sum of the squares of the first ten natural numbers and the square of the sum is 3025 − 385 = 2640.
            Find the difference between the sum of the squares of the first one hundred natural numbers and the square of the sum.
            DESCRIPTION;
    }

    public function run() : string
    {
        $square = 0;
        $sum = 0;

        for ($i = 1; $i <= $n; ++$i) {
            $square += $i * $i;
            $sum += $i;
        }

        return '' . ($sum * $sum - $square);
    }
}
