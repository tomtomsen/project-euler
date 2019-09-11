<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\Problems\Problem34;

use tomtomsen\ProjectEuler\Problem;

final class DigitFactorials implements Problem
{
    public function number() : int
    {
        return 34;
    }

    public function name() : string
    {
        return 'Digit factorials';
    }

    public function description() : string
    {
        return <<<'DESCRIPTION'
            145 is a curious number, as 1! + 4! + 5! = 1 + 24 + 120 = 145.
            Find the sum of all numbers which are equal to the sum of the factorial of their digits.
            Note: as 1! = 1 and 2! = 2 are not sums they are not included.
            DESCRIPTION;
    }

    /*
     * like in DigitFifthPowers::run:
     * 9! = 362880
     * with 7 digits you can represent 2540160
     * with 8 digits you can represent 2903040 (which has 7 digits max)
     */
    public function run() : string
    {
        $factorials = [
            0 => 1,
        ];

        for ($n = 1; 10 > $n; ++$n) {
            $factorials[$n] = $factorials[$n - 1] * $n;
        }

        $sum = 0;

        for ($n = 10; $factorials[9] * 7 > $n; ++$n) {
            $strN = "{$n}";

            $factorialSum = 0;

            for ($digitIdx = 0; \mb_strlen($strN) > $digitIdx; ++$digitIdx) {
                $factorialSum += $factorials[(int) $strN[$digitIdx]];
            }

            if ("{$factorialSum}" === "{$n}") {
                $sum += $factorialSum;
            }
        }

        return "{$sum}";
    }
}
